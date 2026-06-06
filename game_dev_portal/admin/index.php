<?php
require_once '../api/auth.php';
require_once '../api/data.php';
requireLogin();

$games   = getGames();
$devInfo = getDevInfo();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&family=Share+Tech+Mono&family=Orbitron:wght@700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/admin.css" />
</head>
<body class="admin-body">

<aside class="sidebar">
  <div class="sidebar-logo">
    <span class="login-bracket">[</span>ADMIN<span class="login-bracket">]</span>
  </div>
  <nav class="sidebar-nav">
    <a href="index.php" class="sidebar-link active">◈ DASHBOARD</a>
    <a href="game-new.php" class="sidebar-link">+ NEW GAME</a>
    <a href="dev-profile.php" class="sidebar-link">◎ DEV PROFILE</a>
    <a href="../index.php" class="sidebar-link" target="_blank">↗ VIEW SITE</a>
    <a href="logout.php" class="sidebar-link sidebar-logout">⏻ LOGOUT</a>
  </nav>
</aside>

<main class="admin-main">
  <header class="admin-header">
    <h1 class="admin-title">DASHBOARD</h1>
    <a href="game-new.php" class="btn-admin-primary">+ ADD GAME</a>
  </header>

  <div class="admin-stats">
    <div class="stat-card">
      <span class="stat-num"><?= count($games) ?></span>
      <span class="stat-label">TOTAL GAMES</span>
    </div>
    <div class="stat-card">
      <span class="stat-num"><?= count(array_filter($games, fn($g) => $g['status'] === 'active')) ?></span>
      <span class="stat-label">ACTIVE</span>
    </div>
    <div class="stat-card">
      <span class="stat-num"><?= count(array_filter($games, fn($g) => $g['status'] !== 'active')) ?></span>
      <span class="stat-label">IN DEVELOPMENT</span>
    </div>
  </div>

  <section class="admin-section">
    <h2 class="admin-section-title">GAMES</h2>
    <?php if (empty($games)): ?>
      <div class="admin-empty">No games yet. <a href="game-new.php">Add your first game →</a></div>
    <?php else: ?>
    <div class="games-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>TITLE</th>
            <th>VERSION</th>
            <th>STATUS</th>
            <th>PATCHES</th>
            <th>ACTIONS</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($games as $game): ?>
          <tr>
            <td class="td-title"><?= htmlspecialchars($game['title']) ?></td>
            <td><span class="version-badge">v<?= htmlspecialchars($game['latest_version']) ?></span></td>
            <td><span class="status-pill <?= $game['status'] === 'active' ? 'pill-active' : 'pill-dev' ?>"><?= strtoupper(htmlspecialchars($game['status'])) ?></span></td>
            <td><?= count($game['patch_notes'] ?? []) ?></td>
            <td class="td-actions">
              <a href="game-edit.php?id=<?= htmlspecialchars($game['id']) ?>" class="action-btn">EDIT</a>
              <a href="patch-new.php?id=<?= htmlspecialchars($game['id']) ?>" class="action-btn action-patch">+ PATCH</a>
              <a href="game-delete.php?id=<?= htmlspecialchars($game['id']) ?>" class="action-btn action-delete" onclick="return confirm('Delete this game?')">DEL</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </section>
</main>

</body>
</html>
