<?php
require_once '../api/auth.php';
require_once '../api/data.php';
requireLogin();

$devInfo = getDevInfo();
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updated = [
        'name'             => trim($_POST['name'] ?? ''),
        'studio_name'      => trim($_POST['studio_name'] ?? ''),
        'tagline'          => trim($_POST['tagline'] ?? ''),
        'role'             => trim($_POST['role'] ?? ''),
        'hero_description' => trim($_POST['hero_description'] ?? ''),
        'bio'              => trim($_POST['bio'] ?? ''),
        'email'            => trim($_POST['email'] ?? ''),
        'discord'          => trim($_POST['discord'] ?? ''),
        'avatar'           => trim($_POST['avatar'] ?? ''),
        'contact_note'     => trim($_POST['contact_note'] ?? ''),
        'skills'           => array_values(array_filter(array_map('trim', explode("\n", $_POST['skills'] ?? '')))),
        'social'           => [
            'twitter' => trim($_POST['social_twitter'] ?? ''),
            'github'  => trim($_POST['social_github'] ?? ''),
            'itch'    => trim($_POST['social_itch'] ?? ''),
            'youtube' => trim($_POST['social_youtube'] ?? ''),
        ],
    ];
    saveDevInfo($updated);
    $devInfo = $updated;
    $msg = 'Profile saved!';
}

$skillsTxt   = implode("\n", $devInfo['skills'] ?? []);
$social      = $devInfo['social'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dev Profile — Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&family=Share+Tech+Mono&family=Orbitron:wght@700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/admin.css" />
</head>
<body class="admin-body">
<aside class="sidebar">
  <div class="sidebar-logo"><span class="login-bracket">[</span>ADMIN<span class="login-bracket">]</span></div>
  <nav class="sidebar-nav">
    <a href="index.php" class="sidebar-link">◈ DASHBOARD</a>
    <a href="game-new.php" class="sidebar-link">+ NEW GAME</a>
    <a href="dev-profile.php" class="sidebar-link active">◎ DEV PROFILE</a>
    <a href="../index.php" class="sidebar-link" target="_blank">↗ VIEW SITE</a>
    <a href="logout.php" class="sidebar-link sidebar-logout">⏻ LOGOUT</a>
  </nav>
</aside>
<main class="admin-main">
  <header class="admin-header">
    <h1 class="admin-title">DEV PROFILE</h1>
  </header>
  <?php if ($msg): ?>
    <div class="admin-success"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>
  <form method="POST" class="admin-form">
    <div class="form-section">
      <h3>STUDIO / IDENTITY</h3>
      <div class="form-row">
        <div class="field-group">
          <label>YOUR NAME</label>
          <input type="text" name="name" value="<?= htmlspecialchars($devInfo['name'] ?? '') ?>" placeholder="Developer Name" />
        </div>
        <div class="field-group">
          <label>STUDIO NAME</label>
          <input type="text" name="studio_name" value="<?= htmlspecialchars($devInfo['studio_name'] ?? '') ?>" placeholder="DWYNREX" />
        </div>
      </div>
      <div class="form-row">
        <div class="field-group">
          <label>HERO TAGLINE (big text)</label>
          <input type="text" name="tagline" value="<?= htmlspecialchars($devInfo['tagline'] ?? '') ?>" placeholder="INDIE GAME STUDIO" />
        </div>
        <div class="field-group">
          <label>ROLE</label>
          <input type="text" name="role" value="<?= htmlspecialchars($devInfo['role'] ?? '') ?>" placeholder="Solo Indie Developer" />
        </div>
      </div>
      <div class="field-group">
        <label>HERO DESCRIPTION (below tagline)</label>
        <textarea name="hero_description" rows="2"><?= htmlspecialchars($devInfo['hero_description'] ?? '') ?></textarea>
      </div>
      <div class="field-group">
        <label>ABOUT ME BIO</label>
        <textarea name="bio" rows="5"><?= htmlspecialchars($devInfo['bio'] ?? '') ?></textarea>
      </div>
      <div class="field-group">
        <label>SKILLS / TOOLS (one per line)</label>
        <textarea name="skills" rows="4"><?= htmlspecialchars($skillsTxt) ?></textarea>
      </div>
      <div class="field-group">
        <label>AVATAR IMAGE URL</label>
        <input type="text" name="avatar" value="<?= htmlspecialchars($devInfo['avatar'] ?? '') ?>" placeholder="https://..." />
      </div>
    </div>

    <div class="form-section">
      <h3>CONTACT</h3>
      <div class="form-row">
        <div class="field-group">
          <label>EMAIL</label>
          <input type="email" name="email" value="<?= htmlspecialchars($devInfo['email'] ?? '') ?>" placeholder="you@example.com" />
        </div>
        <div class="field-group">
          <label>DISCORD</label>
          <input type="text" name="discord" value="<?= htmlspecialchars($devInfo['discord'] ?? '') ?>" placeholder="user#1234 or server link" />
        </div>
      </div>
      <div class="field-group">
        <label>CONTACT NOTE</label>
        <textarea name="contact_note" rows="2"><?= htmlspecialchars($devInfo['contact_note'] ?? '') ?></textarea>
      </div>
    </div>

    <div class="form-section">
      <h3>SOCIAL LINKS</h3>
      <div class="form-row">
        <div class="field-group">
          <label>TWITTER / X</label>
          <input type="text" name="social_twitter" value="<?= htmlspecialchars($social['twitter'] ?? '') ?>" />
        </div>
        <div class="field-group">
          <label>GITHUB</label>
          <input type="text" name="social_github" value="<?= htmlspecialchars($social['github'] ?? '') ?>" />
        </div>
      </div>
      <div class="form-row">
        <div class="field-group">
          <label>ITCH.IO</label>
          <input type="text" name="social_itch" value="<?= htmlspecialchars($social['itch'] ?? '') ?>" />
        </div>
        <div class="field-group">
          <label>YOUTUBE</label>
          <input type="text" name="social_youtube" value="<?= htmlspecialchars($social['youtube'] ?? '') ?>" />
        </div>
      </div>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn-admin-primary">SAVE PROFILE</button>
    </div>
  </form>
</main>
</body>
</html>
