<?php
require_once '../api/auth.php';
require_once '../api/data.php';
requireLogin();

$gameId = $_GET['id'] ?? '';
$game   = getGame($gameId);
if (!$game) { header('Location: index.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $games = getGames();
    foreach ($games as &$g) {
        if ($g['id'] === $gameId) {
            $version = trim($_POST['version'] ?? '');
            // update latest_version if this is newer
            if ($version) $g['latest_version'] = $version;
            $changes = array_values(array_filter(array_map('trim', explode("\n", $_POST['changes'] ?? ''))));
            $g['patch_notes'][] = [
                'version' => $version,
                'date'    => date('M j, Y'),
                'tag'     => trim($_POST['tag'] ?? ''),
                'changes' => $changes,
            ];
            break;
        }
    }
    saveGames($games);
    header('Location: game-edit.php?id=' . urlencode($gameId) . '&patched=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Patch Note — Admin</title>
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
    <h1 class="admin-title">ADD PATCH NOTE<br><small style="font-size:.6em;color:var(--accent)"><?= htmlspecialchars($game['title']) ?></small></h1>
  </header>
  <form method="POST" class="admin-form">
    <div class="form-section">
      <div class="form-row">
        <div class="field-group">
          <label>VERSION *</label>
          <input type="text" name="version" required placeholder="0.3.0" />
        </div>
        <div class="field-group">
          <label>TAG (optional)</label>
          <input type="text" name="tag" placeholder="Latest Release, Hotfix, Beta..." />
        </div>
      </div>
      <div class="field-group">
        <label>CHANGES (one per line) *</label>
        <textarea name="changes" rows="8" required placeholder="Added new area: Dark Forest&#10;Fixed collision bug on level 3&#10;Improved enemy AI pathing&#10;Performance optimizations"></textarea>
      </div>
    </div>
    <div class="form-actions">
      <a href="game-edit.php?id=<?= htmlspecialchars($gameId) ?>" class="btn-admin-ghost">CANCEL</a>
      <button type="submit" class="btn-admin-primary">PUBLISH PATCH NOTE</button>
    </div>
  </form>
</main>
</body>
</html>
