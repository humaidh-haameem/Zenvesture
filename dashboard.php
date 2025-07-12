<?php
/* ---------- 1. SESSION SECURITY ---------- */
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

/* ---------- 2. PATH HELPERS ---------- */
define('DATA_DIR', __DIR__ . '/data');
define('UPLOAD_DIR', __DIR__ . '/uploads');
function dataPath($file) { return DATA_DIR . "/$file"; }

/* ---------- 3. AUTO-CREATE MISSING FILES ---------- */
foreach (['products.json','banner.json','carousel.json','logs.json'] as $f) {
    if (!file_exists(dataPath($f))) file_put_contents(dataPath($f), $f==='logs.json' ? "[]" : ($f==='banner.json' ? '{"text":"","bg":"#ffffff"}' : "[]"));
}

/* ---------- 4. LOGGING ---------- */
function addLog($action, $section) {
    $logs = json_decode(file_get_contents(dataPath('logs.json')), true);
    $logs[] = ['time' => date('Y-m-d H:i:s'), 'action' => $action, 'section' => $section];
    file_put_contents(dataPath('logs.json'), json_encode($logs, JSON_PRETTY_PRINT));
}

/* ---------- 5. LOGOUT ---------- */
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

/* ---------- 6. POST HANDLERS ---------- */
/* 6a. Add/Edit Product */
if (isset($_POST['save_product'])) {
    $products = json_decode(file_get_contents(dataPath('products.json')), true);
    $img = $_POST['old_image'] ?? '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $fname = uniqid('img_') . ".$ext";
        move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_DIR . "/$fname");
        $img = "uploads/$fname";
    }
    $entry = [
        'id'      => $_POST['id'] ?? uniqid(),
        'title'   => $_POST['title'],
        'content' => $_POST['content'],
        'image'   => $img,
        'category'=> $_POST['category']
    ];
    if ($_POST['id'] ?? false) { // EDIT
        foreach ($products as $k=>$p) if ($p['id']===$entry['id']) $products[$k]=$entry;
        addLog('Edited','Product');
    } else { // ADD
        $products[] = $entry;
        addLog('Added','Product');
    }
    file_put_contents(dataPath('products.json'), json_encode($products, JSON_PRETTY_PRINT));
    header('Location: dashboard.php?success=product_saved');
    exit;
}

/* 6b. Delete Product */
if (isset($_GET['delete_product'])) {
    $products = json_decode(file_get_contents(dataPath('products.json')), true);
    $products = array_filter($products, fn($p)=>$p['id']!=$_GET['delete_product']);
    file_put_contents(dataPath('products.json'), json_encode($products, JSON_PRETTY_PRINT));
    addLog('Deleted','Product');
    header('Location: dashboard.php?success=product_deleted');
    exit;
}

/* 6c. Update Banner */
if (isset($_POST['save_banner'])) {
    $banner = ['text'=>$_POST['banner_text'],'bg'=>$_POST['banner_bg']];
    file_put_contents(dataPath('banner.json'), json_encode($banner, JSON_PRETTY_PRINT));
    addLog('Updated','Banner');
    header('Location: dashboard.php?success=banner_updated');
    exit;
}

/* 6d. Carousel Upload */
if (isset($_FILES['carousel_image'])) {
    $carousel = json_decode(file_get_contents(dataPath('carousel.json')), true);
    $ext = strtolower(pathinfo($_FILES['carousel_image']['name'], PATHINFO_EXTENSION));
    $fname = uniqid('car_') . ".$ext";
    move_uploaded_file($_FILES['carousel_image']['tmp_name'], UPLOAD_DIR . "/$fname");
    $carousel[] = "uploads/$fname";
    file_put_contents(dataPath('carousel.json'), json_encode($carousel, JSON_PRETTY_PRINT));
    addLog('Added','Carousel');
    header('Location: dashboard.php?success=carousel_updated');
    exit;
}

/* 6e. Remove Carousel Image */
if (isset($_GET['remove_carousel'])) {
    $carousel = json_decode(file_get_contents(dataPath('carousel.json')), true);
    $carousel = array_filter($carousel, fn($c)=>$c!=$_GET['remove_carousel']);
    file_put_contents(dataPath('carousel.json'), json_encode(array_values($carousel), JSON_PRETTY_PRINT));
    addLog('Deleted','Carousel');
    header('Location: dashboard.php?success=carousel_updated');
    exit;
}

/* 6f. Clear Logs */
if (isset($_GET['clear_logs'])) {
    file_put_contents(dataPath('logs.json'), "[]");
    header('Location: dashboard.php?success=logs_cleared');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <title>Admin • Fashion Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"/>
  <style>
    :root { --sidebar-width: 250px; }
    body { font-family: "Segoe UI", sans-serif; background: #f8f9fa; }
    #sidebar {
      width: var(--sidebar-width); height: 100vh; position: fixed;
      top:0; left:0; background: linear-gradient(135deg,#8B4513,#A0522D);
      color:#fff; transition: .3s; overflow-y: auto;
    }
    #sidebar .nav-link { color:#fff; font-weight:500; transition:.2s; }
    #sidebar .nav-link:hover { background:rgba(255,255,255,.1); border-radius:6px; }
    #main { margin-left: var(--sidebar-width); padding: 20px; }
    .section-block { display:none; }
    .section-block.active { display:block; animation: fadeIn .4s; }
    @keyframes fadeIn { from {opacity:0;transform:translateY(10px;} to {opacity:1;transform:none;} }
    .card-hover:hover { transform: translateY(-4px); transition:.3s; box-shadow:0 8px 20px rgba(0,0,0,.12); }
    .img-thumb { width: 100px; height: 70px; object-fit:cover; border-radius:6px; }
  </style>
</head>
<body>

<!-- ========== SIDEBAR ========== -->
<nav id="sidebar" class="p-3 d-flex flex-column">
  <h4 class="mt-3 mb-4 text-center"><i class="bi bi-palette"></i> Fashion Admin</h4>
  <p class="text-center small">Hello, <strong><?= htmlspecialchars($_SESSION['user']) ?></strong></p>
  <ul class="nav flex-column gap-2">
    <li><a href="#collection" class="nav-link active" data-section="collection"><i class="bi bi-plus-circle"></i> Add Collection</a></li>
    <li><a href="#edit" class="nav-link" data-section="edit"><i class="bi bi-pencil-square"></i> Edit/Remove</a></li>
    <li><a href="#banner" class="nav-link" data-section="banner"><i class="bi bi-megaphone"></i> Edit Banner</a></li>
    <li><a href="#carousel" class="nav-link" data-section="carousel"><i class="bi bi-images"></i> Carousel</a></li>
    <li><a href="#logs" class="nav-link" data-section="logs"><i class="bi bi-card-list"></i> View Logs</a></li>
  </ul>
  <div class="mt-auto">
    <a href="?logout=1" class="btn btn-outline-light w-100"><i class="bi bi-box-arrow-left"></i> Logout</a>
  </div>
</nav>

<!-- ========== MAIN ========== -->
<main id="main">
  <!-- Alerts -->
  <?php if (isset($_GET['success'])): ?>
    <script>
      const map = {
        product_saved:'New Collection Item Added Successfully!',
        product_deleted:'Collection Post Deleted!',
        banner_updated:'Banner Updated Successfully!',
        carousel_updated:'Carousel Updated!',
        logs_cleared:'Logs Cleared!'
      };
      Swal.fire({ icon:'success', title: map['<?=$_GET['success']?>'], timer:2000, showConfirmButton:false });
    </script>
  <?php endif; ?>

  <!-- ===== SECTION 1: Add Collection ===== -->
  <section id="collection" class="section-block active" data-aos="fade-up">
    <div class="card shadow">
      <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg,#8B4513,#A0522D);">
        <h5><i class="bi bi-plus-circle"></i> Add New Collection Post</h5>
      </div>
      <div class="card-body">
        <form method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="form-label">Post Title</label>
            <input type="text" name="title" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea name="content" class="form-control" rows="4" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
          </div>
          <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category" class="form-select">
              <option>Abayas</option>
              <option>Shawls</option>
              <option>New Arrivals</option>
              <option>Best Sellers</option>
            </select>
          </div>
          <button name="save_product" class="btn btn-primary"><i class="bi bi-check-circle"></i> Save Post</button>
        </form>
      </div>
    </div>
  </section>

  <!-- ===== SECTION 2: Edit / Remove (ADMIN TABLE + INLINE EDIT MODAL) ===== -->
<section id="edit" class="section-block" data-aos="fade-up">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Manage Posts</h4>
  </div>

  <?php
  /* --- ALWAYS load products in dashboard.php once at top --- */
  $products = json_decode(file_get_contents(dataPath('products.json')), true) ?: [];
  ?>

  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="table-dark">
        <tr>
          <th class="text-center" style="width:80px">Image</th>
          <th>Title</th>
          <th class="text-center" style="width:120px">Category</th>
          <th class="text-center" style="width:160px">Actions</th>
        </tr>
      </thead>

      <tbody>
      <?php if (!$products): ?>
        <tr>
          <td colspan="4" class="text-center text-muted py-4">No collection posts yet.</td>
        </tr>
      <?php else: ?>
        <?php foreach ($products as $p): ?>
        <tr>
          <td class="text-center">
            <img src="<?= $p['image'] ?>" width="60" height="40" class="rounded object-fit-cover">
          </td>
          <td><?= htmlspecialchars($p['title']) ?></td>
          <td class="text-center">
            <span class="badge bg-secondary"><?= htmlspecialchars($p['category']) ?></span>
          </td>
          <td class="text-center">
            <!-- EDIT button triggers inline modal -->
            <button class="btn btn-sm btn-warning"
                    data-bs-toggle="modal"
                    data-bs-target="#editModal<?= $p['id'] ?>">
              <i class="bi bi-pencil"></i> Edit
            </button>

            <!-- DELETE link -->
            <a href="?delete_product=<?= $p['id'] ?>"
               class="btn btn-sm btn-danger ms-1"
               onclick="return confirm('Delete this item?')">
              <i class="bi bi-trash"></i>
            </a>
          </td>
        </tr>

        <!-- ===== Inline Bootstrap Modal for EDIT ===== -->
        <div class="modal fade" id="editModal<?= $p['id'] ?>" tabindex="-1"
             aria-labelledby="editModalLabel<?= $p['id'] ?>" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <form method="post" enctype="multipart/form-data">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel<?= $p['id'] ?>">Edit Post</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                  <input type="hidden" name="id" value="<?= $p['id'] ?>">
                  <input type="hidden" name="old_image" value="<?= $p['image'] ?>">

                  <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($p['title']) ?>" required>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" class="form-control" rows="4" required><?= htmlspecialchars($p['content']) ?></textarea>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select">
                      <?php foreach (['Abayas','Shawls','New Arrivals','Best Sellers'] as $cat): ?>
                        <option value="<?= $cat ?>" <?= $cat===$p['category'] ? 'selected' : '' ?>><?= $cat ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Image (leave empty to keep current)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Current: <a href="<?= $p['image'] ?>" target="_blank">view</a></small>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" name="save_product" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- ===== /Modal ===== -->

        <?php endforeach; ?>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</section>

  <!-- ===== SECTION 3: Banner ===== -->
  <section id="banner" class="section-block" data-aos="fade-up">
    <div class="card shadow">
      <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg,#8B4513,#A0522D);">
        <h5><i class="bi bi-megaphone"></i> Edit Banner</h5>
      </div>
      <div class="card-body">
        <?php $banner = json_decode(file_get_contents(dataPath('banner.json')), true); ?>
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Banner Text</label>
            <textarea name="banner_text" class="form-control" rows="2"><?= htmlspecialchars($banner['text']) ?></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Background Color (hex)</label>
            <input type="color" name="banner_bg" class="form-control form-control-color" value="<?= htmlspecialchars($banner['bg']) ?>">
          </div>
          <button name="save_banner" class="btn btn-primary"><i class="bi bi-check-circle"></i> Update Banner</button>
        </form>
      </div>
    </div>
  </section>

  <!-- ===== SECTION 4: Carousel ===== -->
  <section id="carousel" class="section-block" data-aos="fade-up">
    <h4><i class="bi bi-images"></i> Manage Carousel</h4>
    <form method="post" enctype="multipart/form-data" class="mb-4">
      <div class="input-group">
        <input type="file" name="carousel_image" class="form-control" accept="image/*" required>
        <button class="btn btn-outline-primary" name="upload_carousel"><i class="bi bi-upload"></i> Upload</button>
      </div>
    </form>
    <div class="row g-3">
      <?php
      $carousel = json_decode(file_get_contents(dataPath('carousel.json')), true);
      foreach ($carousel as $img): ?>
      <div class="col-auto position-relative">
        <img src="<?= $img ?>" class="img-thumb">
        <a href="?remove_carousel=<?= urlencode($img) ?>" class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle rounded-circle" style="width:24px;height:24px;font-size:12px;"><i class="bi bi-x"></i></a>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ===== SECTION 5: Logs ===== -->
  <section id="logs" class="section-block" data-aos="fade-up">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4><i class="bi bi-card-list"></i> Activity Logs</h4>
      <a href="?clear_logs=1" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Clear All</a>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-dark">
          <tr><th>Time</th><th>Action</th><th>Section</th></tr>
        </thead>
        <tbody>
          <?php
          $logs = json_decode(file_get_contents(dataPath('logs.json')), true);
          foreach (array_reverse($logs) as $l): ?>
          <tr>
            <td><?= $l['time'] ?></td>
            <td><span class="badge bg-secondary"><?= $l['action'] ?></span></td>
            <td><?= $l['section'] ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>
</main>

<!-- ========== FOOTER ========== -->
<footer style="text-align:center;padding:10px;font-size:14px;background:#f8f9fa;margin-left:var(--sidebar-width);">
  Developed by <strong><a href="https://www.facebook.com/mhm.humaidh" target="_blank">Cyber Bro IT Solution</a></strong> © 2025
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ once:true });
/* SECTION NAVIGATION */
document.querySelectorAll('[data-section]').forEach(link=>{
  link.addEventListener('click', e=>{
    e.preventDefault();
    const target = link.dataset.section;
    document.querySelectorAll('.section-block').forEach(sec=>sec.classList.remove('active'));
    document.getElementById(target).classList.add('active');
    document.querySelectorAll('#sidebar .nav-link').forEach(l=>l.classList.remove('active'));
    link.classList.add('active');
  });
});
</script>
</body>
</html>