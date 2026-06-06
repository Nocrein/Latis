<?php
require_once '../api/auth.php';
require_once '../api/data.php';

if (session_status() === PHP_SESSION_NONE) session_start();
if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';
    if (checkLogin($email, $pass)) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid credentials.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&family=Share+Tech+Mono&family=Orbitron:wght@700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/admin.css" />
</head>
<body class="login-body">
  <div class="login-bg">
    <div class="login-grid"></div>
    <div class="login-glow"></div>
  </div>
  <div class="login-box">
    <div class="login-logo">
      <span class="login-bracket">[</span>ADMIN<span class="login-bracket">]</span>
    </div>
    <p class="login-sub">SECURE ACCESS REQUIRED</p>
    <?php if ($error): ?>
      <div class="login-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" class="login-form">
      <div class="field-group">
        <label>EMAIL / USERNAME</label>
        <input type="text" name="email" placeholder="admin" required autocomplete="username" />
      </div>
      <div class="field-group">
        <label>PASSWORD</label>
        <input type="password" name="password" placeholder="••••••••" required autocomplete="current-password" />
      </div>
      <button type="submit" class="btn-login">ACCESS PANEL</button>
    </form>
    <a href="../index.php" class="back-link">← Back to site</a>
  </div>
</body>
</html>
