<?php
require_once '../api/auth.php';
require_once '../api/data.php';
requireLogin();

$id   = $_GET['id'] ?? '';
$game = getGame($id);
if (!$game) { header('Location: index.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $games = getGames();
    foreach ($games as &$g) {
        if ($g['id'] === $id) {
            $g['title']           = trim($_POST['title'] ?? $g['title']);
            $g['genre']           = trim($_POST['genre'] ?? '');
            $g['status']          = $_POST['status'] ?? $g['status'];
            $g['latest_version']  = trim($_POST['latest_version'] ?? $g['latest_version']);
            $g['description']     = trim($_POST['description'] ?? '');
            $g['long_description']= trim($_POST['long_description'] ?? '');
            $g['features']        = array_values(array_filter(array_map('trim', explode("\n", $_POST['features'] ?? ''))));
            $g['cover_image']     = trim($_POST['cover_image'] ?? '');
            $g['screenshots']     = array_values(array_filter(array_map('trim', explode("\n", $_POST['screenshots'] ?? ''))));
            $g['download_links']  = [
                'windows' => trim($_POST['dl_windows'] ?? ''),
                'linux'   => trim($_POST['dl_linux'] ?? ''),
                'mac'     => trim($_POST['dl_mac'] ?? ''),
                'itch'    => trim($_POST['dl_itch'] ?? ''),
                'github'  => trim($_POST['dl_github'] ?? ''),
            ];
            break;
        }
    }
    saveGames($games);
    header('Location: index.php?saved=1');
    exit;
}

$dl = $game['download_links'] ?? [];
$featuresTxt = implode("\n", $game['features'] ?? []);
$ssTxt = implode("\n", $game['screenshots'] ?? []);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Game — Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&family=Share+Tech+Mono&family=Orbitron:wght@700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/admin.css" />
</head>
<body class="admin-body">
<aside class="sidebar">
  <div class="sidebar-logo"><span class="login-bracket">[</span>ADMIN<span class="login-bracket">]</span></div>
  <nav class="sidebar-nav">
    <a href="index.php" class="sidebar-link">◈ DASHBOARD</a>
    <a href="game-new.php" class="sidebar-link">+ NEW GAME</a>
    <a href="dev-profile.php" class="sidebar-link">◎ DEV PROFILE</a>
    <a href="../index.php" class="sidebar-link" target="_blank">↗ VIEW SITE</a>
    <a href="logout.php" class="sidebar-link sidebar-logout">⏻ LOGOUT</a>
  </nav>
</aside>
<main class="admin-main">
  <header class="admin-header">
    <h1 class="admin-title">EDIT: <?= htmlspecialchars($game['title']) ?></h1>
    <a href="patch-new.php?id=<?= htmlspecialchars($id) ?>" class="btn-admin-primary">+ ADD PATCH NOTE</a>
  </header>

  <form method="POST" class="admin-form">
    <div class="form-section">
      <h3>BASIC INFO</h3>
      <div class="form-row">
        <div class="field-group">
          <label>GAME TITLE *</label>
          <input type="text" name="title" required value="<?= htmlspecialchars($game['title']) ?>" />
        </div>
        <div class="field-group">
          <label>GENRE</label>
          <input type="text" name="genre" value="<?= htmlspecialchars($game['genre'] ?? '') ?>" />
        </div>
      </div>
      <div class="form-row">
        <div class="field-group">
          <label>STATUS</label>
          <select name="status">
            <option value="development" <?= ($game['status'] ?? '') === 'development' ? 'selected' : '' ?>>In Development</option>
            <option value="active" <?= ($game['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active / Released</option>
            <option value="hiatus" <?= ($game['status'] ?? '') === 'hiatus' ? 'selected' : '' ?>>On Hiatus</option>
          </select>
        </div>
        <div class="field-group">
          <label>LATEST VERSION</label>
          <input type="text" name="latest_version" value="<?= htmlspecialchars($game['latest_version'] ?? '0.1.0') ?>" />
        </div>
      </div>
      <div class="field-group">
        <label>SHORT DESCRIPTION</label>
        <textarea name="description" rows="2"><?= htmlspecialchars($game['description'] ?? '') ?></textarea>
      </div>
      <div class="field-group">
        <label>LONG DESCRIPTION</label>
        <textarea name="long_description" rows="5"><?= htmlspecialchars($game['long_description'] ?? '') ?></textarea>
      </div>
      <div class="field-group">
        <label>FEATURES (one per line)</label>
        <textarea name="features" rows="4"><?= htmlspecialchars($featuresTxt) ?></textarea>
      </div>
    </div>

    <div class="form-section">
      <h3>MEDIA</h3>
      <div class="field-group">
        <label>COVER IMAGE URL</label>
        <input type="text" name="cover_image" value="<?= htmlspecialchars($game['cover_image'] ?? '') ?>" />
      </div>
      <div class="field-group">
        <label>SCREENSHOT URLS (one per line)</label>
        <textarea name="screenshots" rows="3"><?= htmlspecialchars($ssTxt) ?></textarea>
      </div>
    </div>

    <div class="form-section">
      <h3>DOWNLOAD LINKS</h3>
      <div class="form-row">
        <div class="field-group">
          <label>⊞ WINDOWS</label>
          <input type="text" name="dl_windows" value="<?= htmlspecialchars($dl['windows'] ?? '') ?>" />
        </div>
        <div class="field-group">
          <label>🐧 LINUX</label>
          <input type="text" name="dl_linux" value="<?= htmlspecialchars($dl['linux'] ?? '') ?>" />
        </div>
      </div>
      <div class="form-row">
        <div class="field-group">
          <label>⌘ MAC</label>
          <input type="text" name="dl_mac" value="<?= htmlspecialchars($dl['mac'] ?? '') ?>" />
        </div>
        <div class="field-group">
          <label>◈ ITCH.IO</label>
          <input type="text" name="dl_itch" value="<?= htmlspecialchars($dl['itch'] ?? '') ?>" />
        </div>
      </div>
      <div class="field-group">
        <label>⌂ GITHUB RELEASES</label>
        <input type="text" name="dl_github" value="<?= htmlspecialchars($dl['github'] ?? '') ?>" />
      </div>
    </div>

    <div class="form-actions">
      <a href="index.php" class="btn-admin-ghost">CANCEL</a>
      <button type="submit" class="btn-admin-primary">SAVE CHANGES</button>
    </div>
  </form>

  <!-- PATCH NOTES LIST -->
  <div class="form-section" style="margin-top:2rem;">
    <h3>PATCH NOTES <a href="patch-new.php?id=<?= htmlspecialchars($id) ?>" class="btn-admin-primary" style="font-size:.75rem;padding:.3rem .8rem;">+ ADD</a></h3>
    <?php if (!empty($game['patch_notes'])): ?>
    <div class="patches-admin-list">
      <?php foreach (array_reverse($game['patch_notes'], true) as $pi => $patch): ?>
      <div class="patch-admin-entry">
        <div class="patch-admin-header">
          <span class="patch-version">v<?= htmlspecialchars($patch['version']) ?></span>
          <span class="patch-date"><?= htmlspecialchars($patch['date']) ?></span>
          <?php if (!empty($patch['tag'])): ?><span class="patch-tag"><?= htmlspecialchars($patch['tag']) ?></span><?php endif; ?>
          <a href="patch-delete.php?game=<?= htmlspecialchars($id) ?>&index=<?= count($game['patch_notes']) - 1 - $pi ?>" class="action-btn action-delete" onclick="return confirm('Delete patch note?')">DEL</a>
        </div>
        <ul class="patch-changes" style="margin:.5rem 0 0 1rem;">
          <?php foreach ($patch['changes'] as $c): ?>
            <li><?= htmlspecialchars($c) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p style="color:var(--text-muted);font-family:var(--font-mono);">No patch notes yet.</p>
    <?php endif; ?>
  </div>
</main>
</body>
</html>
