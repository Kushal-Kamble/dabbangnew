<?php 
// admin/newsletter_add_all.php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require_once "../config.php";
require_once "../inc/mailer.php"; // for send now
$msg = "";

// Fetch categories
$cats_res = $conn->query("SELECT id,name FROM categories ORDER BY name ASC");
$categories = [];
while ($r = $cats_res->fetch_assoc()) {
    $categories[] = $r;
}

// Sections definition
$sections_def = [
    'this_weeks_insights' => "This Week’s Insights",
    'quick_bytes'         => "Quick Bytes",
    'ai_tip'              => "AI Tip of the Week",
    'toolbox'             => "Toolbox",
    'market_news'         => "Market News",
    'wellnessbyte'        => "Wellnessbyte",
    'quote_of_the_day'    => "Quote of the Day",
];

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title'] ?? '');
    $image       = trim($_POST['image'] ?? '');
    $video       = trim($_POST['video'] ?? '');
    $send_type   = $_POST['send_type'] ?? 'schedule'; // now | schedule
    $scheduled_at = !empty($_POST['scheduled_at']) ? $_POST['scheduled_at'] : null;

    // collect sections
    $posted_sections = $_POST['sections'] ?? [];
    $multi = [];
    foreach ($sections_def as $slug => $label) {
        $sec = $posted_sections[$slug] ?? [];
        $cat_id = !empty($sec['category_id']) ? (int)$sec['category_id'] : null;
        $subcategory = trim($sec['subcategory'] ?? '');
        $content = $sec['content'] ?? '';
        $post_id = !empty($sec['post_id']) ? (int)$sec['post_id'] : null;
        $post_url = null;
        if ($post_id && !empty($BASE_URL)) {
            $post_url = rtrim($BASE_URL, '/') . "/public/post.php?id=" . $post_id;
        }
        $multi[$slug] = [
            'label'       => $label,
            'category_id' => $cat_id,
            'subcategory' => $subcategory,
            'content'     => $content,
            'post_id'     => $post_id,
            'post_url'    => $post_url
        ];
    }

    // fallback for single preview
    $fallback_category_id = null;
    $fallback_subcategory = null;
    $fallback_content     = null;
    foreach ($multi as $m) {
        if (!empty($m['content']) || !empty($m['post_id'])) {
            $fallback_category_id = $m['category_id'];
            $fallback_subcategory = $m['subcategory'];
            $fallback_content     = $m['content'];
            break;
        }
    }

    $multi_json = json_encode($multi, JSON_UNESCAPED_SLASHES);
    $links = null;
    $sent_status = 'pending';

    // Insert
    $sql = "INSERT INTO newsletter_master 
        (title, category_id, subcategory, editor_content, image, video, links, multi_content, scheduled_at, sent_status)
        VALUES (?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $msg = "<div class='alert alert-danger'>❌ Prepare failed: " . $conn->error . "</div>";
    } else {
        $cat_bind   = $fallback_category_id ?? null;
        $sched_bind = $scheduled_at ?: null;

        $stmt->bind_param(
            "sissssssss", // 10 params
            $title,
            $cat_bind,
            $fallback_subcategory,
            $fallback_content,
            $image,
            $video,
            $links,
            $multi_json,
            $sched_bind,
            $sent_status
        );

        if ($stmt->execute()) {
            $nid = $stmt->insert_id;
            if ($send_type === 'now') {
                require_once __DIR__ . "/newsletter_send_helper_all.php";
                $ok = send_newsletter_now_all($nid, $conn, $BASE_URL);
                $msg = $ok
                    ? "<div class='alert alert-success'>✅ Multi-newsletter created & sent successfully!</div>"
                    : "<div class='alert alert-warning'>⚠️ Created but sending failed. Check logs.</div>";
            } else {
                $msg = "<div class='alert alert-success'>✅ Multi-newsletter scheduled/created successfully!</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>❌ Error while saving: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Create Multi-Category Newsletter</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
  <style>
    body { background:#f6f8fb; }
    .card { border-radius:12px; }
    .section-card { border-radius:10px; margin-bottom:14px; }
    .small-muted { font-size:13px; color:#666; }
    .section-header { display:flex; justify-content:space-between; align-items:center; gap:12px; }
  </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="content">
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="m-0">📰 Create Multi-Category Newsletter</h3>
      <a href="newsletters_all.php" class="btn btn-outline-secondary"><i class="bi bi-list-ul"></i> All Multi Newsletters</a>
    </div>

    <?= $msg ?>

    <div class="card shadow-sm">
      <div class="card-body">
        <form method="post" id="multiNewsletterForm">
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Title</label>
              <input name="title" class="form-control" required value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Hero Image URL (optional)</label>
              <input name="image" class="form-control" placeholder="https://..." value="<?= htmlspecialchars($_POST['image'] ?? '') ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Video URL (optional)</label>
              <input name="video" class="form-control" placeholder="https://..." value="<?= htmlspecialchars($_POST['video'] ?? '') ?>">
            </div>
          </div>

          <!-- Sections -->
          <?php foreach ($sections_def as $slug => $label): 
            $selected_category = $_POST['sections'][$slug]['category_id'] ?? ''; ?>
            <div class="card section-card shadow-sm p-3">
              <div class="section-header mb-2">
                <div>
                  <strong><?= htmlspecialchars($label) ?></strong>
                  <div class="small-muted">Section key: <code><?= $slug ?></code></div>
                </div>
                <div class="text-end">
                  <div class="small-muted">Optional — fill if you want this section</div>
                </div>
              </div>

              <div class="row g-2 align-items-end">
                <div class="col-md-3">
                  <label class="form-label">Category</label>
                  <select name="sections[<?= $slug ?>][category_id]" class="form-select section-category" data-section="<?= $slug ?>">
                    <option value="">— Select —</option>
                    <?php foreach ($categories as $c): ?>
                      <option value="<?= (int)$c['id'] ?>" <?= ($selected_category == $c['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-3">
                  <label class="form-label">Subcategory</label>
                  <select name="sections[<?= $slug ?>][subcategory]" class="form-select section-subcategory" id="subcat_<?= $slug ?>" data-section="<?= $slug ?>">
                    <option value="">— Select —</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <label class="form-label">Read More → Post (optional)</label>
                  <select name="sections[<?= $slug ?>][post_id]" class="form-select section-post" id="post_<?= $slug ?>" data-section="<?= $slug ?>">
                    <option value="">— None —</option>
                  </select>
                </div>
                <div class="col-md-3 text-end">
                  <label class="form-label">Preview</label>
                  <div>
                    <button type="button" class="btn btn-sm btn-outline-secondary preview-section" data-section="<?= $slug ?>">Preview</button>
                  </div>
                </div>
                <div class="col-12 mt-2">
                  <label class="form-label">Newsletter Content</label>
                  <textarea name="sections[<?= $slug ?>][content]" id="editor_<?= $slug ?>" rows="6" class="form-control"><?= htmlspecialchars($_POST['sections'][$slug]['content'] ?? '') ?></textarea>
                </div>
              </div>
            </div>
          <?php endforeach; ?>

          <div class="row g-3 mt-3">
            <div class="col-md-3">
              <label class="form-label fw-semibold">Send Type</label>
              <select name="send_type" id="sendType" class="form-select">
                <option value="now">Send Now</option>
                <option value="schedule">Schedule</option>
              </select>
            </div>
            <div class="col-md-4" id="scheduleWrap">
              <label class="form-label fw-semibold">Scheduled At</label>
              <input type="datetime-local" name="scheduled_at" class="form-control">
            </div>
            <div class="col-12 text-end mt-3">
              <button class="btn text-white px-4" style="background:#fd5402;"><i class="bi bi-send"></i> Send / Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  <?php foreach ($sections_def as $slug => $label): ?>
    CKEDITOR.replace('editor_<?= $slug ?>');
  <?php endforeach; ?>

  const sendType = document.getElementById('sendType');
  const scheduleWrap = document.getElementById('scheduleWrap');
  function toggleSchedule(){
    scheduleWrap.style.display = (sendType.value === 'schedule') ? 'block' : 'none';
  }
  sendType.addEventListener('change', toggleSchedule);
  toggleSchedule();

  async function loadSubcategories(section, catId) {
    const subSel = document.getElementById('subcat_' + section);
    subSel.innerHTML = '<option value="">— Select —</option>';
    if (!catId) return;
    const res = await fetch('get_subcategories_all.php?cat_id=' + encodeURIComponent(catId));
    const data = await res.json();
    data.forEach(sc => {
      const opt = document.createElement('option');
      opt.value = sc.name;
      let text = sc.name;
      if (sc.is_used == 1) text += " (✅ Used)";
      if (sc.is_new == 1) text += " (🆕 New)";
      if (sc.created_at) text += " ("+sc.created_at+")";
      opt.textContent = text;
      if (sc.is_used == 1) opt.disabled = true;
      subSel.appendChild(opt);
    });
  }

  async function loadPosts(section, catId) {
    const postSel = document.getElementById('post_' + section);
    postSel.innerHTML = '<option value="">— None —</option>';
    if (!catId) return;
    const res = await fetch('get_posts_by_category_all.php?cat_id=' + encodeURIComponent(catId));
    const data = await res.json();
    data.forEach(p => {
      const opt = document.createElement('option');
      opt.value = p.id;
      let text = p.title;
      if (p.is_used == 1) text += " (✅ Used)";
      if (p.is_new == 1) text += " (🆕 New)";
      if (p.created_at) text += " ("+p.created_at+")";
      opt.textContent = text;
      if (p.is_used == 1) opt.disabled = true;
      postSel.appendChild(opt);
    });
  }

  document.querySelectorAll('.section-category').forEach(sel => {
    const section = sel.dataset.section;
    if (sel.value) {
      loadSubcategories(section, sel.value);
      loadPosts(section, sel.value);
    }
    sel.addEventListener('change', e => {
      loadSubcategories(section, e.target.value);
      loadPosts(section, e.target.value);
    });
  });

  document.querySelectorAll('.preview-section').forEach(btn => {
    btn.addEventListener('click', () => {
      const section = btn.dataset.section;
      const editor = CKEDITOR.instances['editor_' + section];
      const html = editor ? editor.getData() : '';
      const win = window.open('', '_blank', 'width=700,height=700,scrollbars=yes');
      win.document.write('<html><head><title>Preview</title></head><body>' + html + '</body></html>');
      win.document.close();
    });
  });
</script>
<?php include "../inc/footer.php"; ?>
</body>
</html>
