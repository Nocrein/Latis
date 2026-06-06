<?php
require_once '../api/auth.php';
require_once '../api/data.php';
requireLogin();

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $games = getGames();
    $id    = 'game-' . uniqid();
    $newGame = [
        'id'              => $id,
        'title'           => trim($_POST['title'] ?? ''),
        'genre'           => trim($_POST['genre'] ?? ''),
        'status'          => $_POST['status'] ?? 'development',
        'latest_version'  => trim($_POST['latest_version'] ?? '0.1.0'),
        'description'     => trim($_POST['description'] ?? ''),
        'long_description'=> trim($_POST['long_description'] ?? ''),
        'features'        => array_filter(array_map('trim', explode("\n", $_POST['features'] ?? ''))),
        'cover_image'     => trim($_POST['cover_image'] ?? ''),
        'screenshots'     => array_filter(array_map('trim', explode("\n", $_POST['screenshots'] ?? ''))),
        'download_links'  => [
            'windows' => trim($_POST['dl_windows'] ?? ''),
            'linux'   => trim($_POST['dl_linux'] ?? ''),
            'mac'     => trim($_POST['dl_mac'] ?? ''),
            'itch'    => trim($_POST['dl_itch'] ?? ''),
            'github'  => trim($_POST['dl_github'] ?? ''),
        ],
        'patch_notes'  => [],
        'created_at'   => date('Y-m-d'),
    ];
    $games[] = $newGame;
    saveGames($games);
    header('Location: index.php?created=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>New Game — Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&family=Share+Tech+Mono&family=Orbitron:wght@700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/admin.css" />
</head>
<body class="admin-body">
<aside class="sidebar">
  <div class="sidebar-logo"><span class="login-bracket">[</span>ADMIN<span class="login-bracket">]</span></div>
  <nav class="sidebar-nav">
    <a href="index.php" class="sidebar-link">◈ DASHBOARD</a>
    <a href="game-new.php" class="sidebar-link active">+ NEW GAME</a>
    <a href="dev-profile.php" class="sidebar-link">◎ DEV PROFILE</a>
    <a href="../index.php" class="sidebar-link" target="_blank">↗ VIEW SITE</a>
    <a href="logout.php" class="sidebar-link sidebar-logout">⏻ LOGOUT</a>
  </nav>
</aside>
<main class="admin-main">
  <header class="admin-header">
    <h1 class="admin-title">NEW GAME</h1>
  </header>
  <form method="POST" class="admin-form">
    <div class="form-section">
      <h3>BASIC INFO</h3>
      <div class="form-row">
        <div class="field-group">
          <label>GAME TITLE *</label>
          <input type="text" name="title" required placeholder="My Awesome Game" />
        </div>
        <div class="field-group">
          <label>GENRE</label>
          <input type="text" name="genre" placeholder="Action RPG, Platformer..." />
        </div>
      </div>
      <div class="form-row">
        <div class="field-group">
          <label>STATUS</label>
          <select name="status">
            <option value="development">In Development</option>
            <option value="active">Active / Released</option>
            <option value="hiatus">On Hiatus</option>
          </select>
        </div>
        <div class="field-group">
          <label>LATEST VERSION</label>
          <input type="text" name="latest_version" placeholder="0.1.0" value="0.1.0" />
        </div>
      </div>
      <div class="field-group">
        <label>SHORT DESCRIPTION (shown on card)</label>
        <textarea name="description" rows="2" placeholder="A short punchy description of the game..."></textarea>
      </div>
      <div class="field-group">
        <label>LONG DESCRIPTION (shown in About tab)</label>
        <textarea name="long_description" rows="5" placeholder="Full game description with lore, mechanics, etc..."></textarea>
      </div>
      <div class="field-group">
        <label>FEATURES (one per line)</label>
        <textarea name="features" rows="4" placeholder="Open world exploration&#10;Tactical combat&#10;Rich story"></textarea>
      </div>
    </div>

    <div class="form-section">
      <h3>MEDIA</h3>
      <div class="field-group">
        <label>COVER IMAGE URL</label>
        <input type="text" name="cover_image" placeholder="https://..." />
      </div>
      <div class="field-group">
        <label>SCREENSHOT URLS (one per line)</label>
        <textarea name="screenshots" rows="3" placeholder="https://...&#10;https://..."></textarea>
      </div>
    </div>

    <div class="form-section">
      <h3>DOWNLOAD LINKS</h3>
      <div class="form-row">
        <div class="field-group">
          <label>⊞ WINDOWS</label>
          <input type="text" name="dl_windows" placeholder="https://..." />
        </div>
        <div class="field-group">
          <label>🐧 LINUX</label>
          <input type="text" name="dl_linux" placeholder="https://..." />
        </div>
      </div>
      <div class="form-row">
        <div class="field-group">
          <label>⌘ MAC</label>
          <input type="text" name="dl_mac" placeholder="https://..." />
        </div>
        <div class="field-group">
          <label>◈ ITCH.IO</label>
          <input type="text" name="dl_itch" placeholder="https://itch.io/..." />
        </div>
      </div>
      <div class="field-group">
        <label>⌂ GITHUB RELEASES</label>
        <input type="text" name="dl_github" placeholder="https://github.com/.../releases" />
      </div>
    </div>

    <div class="form-actions">
      <a href="index.php" class="btn-admin-ghost">CANCEL</a>
      <button type="submit" class="btn-admin-primary">CREATE GAME</button>
    </div>
  </form>
</main>
</body>
</html>
