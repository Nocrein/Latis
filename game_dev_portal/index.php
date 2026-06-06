<?php
require_once 'api/data.php';
$siteData = getSiteData();
$games = getGames();
$devInfo = getDevInfo();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($devInfo['studio_name'] ?? 'INDIE DEV') ?> — Game Studio</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Share+Tech+Mono&family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/main.css" />
</head>
<body>

<!-- NAV -->
<nav class="nav" id="nav">
  <div class="nav-inner">
    <div class="nav-logo">
      <span class="logo-bracket">[</span>
      <span class="logo-text"><?= htmlspecialchars($devInfo['studio_name'] ?? 'DWYNREX') ?></span>
      <span class="logo-bracket">]</span>
    </div>
    <ul class="nav-links">
      <li><a href="#games">GAMES</a></li>
      <li><a href="#about">ABOUT</a></li>
      <li><a href="#contact">CONTACT</a></li>
      <li><a href="admin/login.php" class="nav-admin">ADMIN</a></li>
    </ul>
    <button class="hamburger" id="hamburger" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<!-- HERO -->
<section class="hero" id="hero">
  <div class="hero-bg">
    <div class="hero-grid"></div>
    <div class="hero-glow glow-1"></div>
    <div class="hero-glow glow-2"></div>
    <div class="scanlines"></div>
  </div>
  <div class="hero-content">
    <div class="hero-eyebrow">
      <span class="eyebrow-line"></span>
      <span><?= htmlspecialchars($devInfo['studio_name'] ?? 'DWYNREX') ?></span>
      <span class="eyebrow-line"></span>
    </div>
    <h1 class="hero-title"><?= htmlspecialchars($devInfo['tagline'] ?? 'INDIE GAME STUDIO') ?></h1>
    <p class="hero-sub"><?= htmlspecialchars($devInfo['hero_description'] ?? 'Crafting immersive experiences from the ground up. Independent. Relentless. Evolving.') ?></p>
    <div class="hero-cta">
      <a href="#games" class="btn btn-primary">VIEW GAMES</a>
      <a href="#about" class="btn btn-ghost">ABOUT DEV</a>
    </div>
  </div>
  <div class="hero-scroll-indicator">
    <span>SCROLL</span>
    <div class="scroll-arrow"></div>
  </div>
</section>

<!-- GAMES SECTION -->
<section class="section games-section" id="games">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">// PROJECTS</span>
      <h2 class="section-title">GAMES</h2>
      <div class="title-line"></div>
    </div>

    <?php if (empty($games)): ?>
      <div class="empty-state">
        <p>No games published yet. Check back soon.</p>
      </div>
    <?php else: ?>
      <div class="games-grid">
        <?php foreach ($games as $game): ?>
        <article class="game-card" id="game-<?= htmlspecialchars($game['id']) ?>">
          <div class="game-card-header">
            <?php if (!empty($game['cover_image'])): ?>
              <img src="<?= htmlspecialchars($game['cover_image']) ?>" alt="<?= htmlspecialchars($game['title']) ?>" class="game-cover" />
            <?php else: ?>
              <div class="game-cover-placeholder">
                <span class="placeholder-icon">◈</span>
              </div>
            <?php endif; ?>
            <div class="game-status-badge <?= $game['status'] === 'active' ? 'badge-active' : 'badge-dev' ?>">
              <?= strtoupper(htmlspecialchars($game['status'] ?? 'IN DEV')) ?>
            </div>
          </div>

          <div class="game-card-body">
            <div class="game-meta-top">
              <span class="game-genre"><?= htmlspecialchars($game['genre'] ?? '') ?></span>
              <span class="game-version">v<?= htmlspecialchars($game['latest_version'] ?? '0.1.0') ?></span>
            </div>
            <h3 class="game-title"><?= htmlspecialchars($game['title']) ?></h3>
            <p class="game-description"><?= htmlspecialchars($game['description']) ?></p>

            <!-- TABS -->
            <div class="tabs" data-game="<?= htmlspecialchars($game['id']) ?>">
              <div class="tab-bar">
                <button class="tab-btn active" data-tab="patchnotes">PATCH NOTES</button>
                <button class="tab-btn" data-tab="about">ABOUT</button>
                <?php if (!empty($game['screenshots'])): ?>
                <button class="tab-btn" data-tab="media">MEDIA</button>
                <?php endif; ?>
              </div>

              <!-- PATCH NOTES TAB -->
              <div class="tab-content active" data-tab="patchnotes">
                <?php if (!empty($game['patch_notes'])): ?>
                  <div class="patchnotes-list">
                    <?php foreach (array_reverse($game['patch_notes']) as $patch): ?>
                    <div class="patch-entry">
                      <div class="patch-header">
                        <span class="patch-version">v<?= htmlspecialchars($patch['version']) ?></span>
                        <span class="patch-date"><?= htmlspecialchars($patch['date']) ?></span>
                        <?php if (!empty($patch['tag'])): ?>
                          <span class="patch-tag"><?= htmlspecialchars($patch['tag']) ?></span>
                        <?php endif; ?>
                      </div>
                      <ul class="patch-changes">
                        <?php foreach ($patch['changes'] as $change): ?>
                          <li><?= htmlspecialchars($change) ?></li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                    <?php endforeach; ?>
                  </div>
                <?php else: ?>
                  <p class="empty-tab">No patch notes yet.</p>
                <?php endif; ?>
              </div>

              <!-- ABOUT TAB -->
              <div class="tab-content" data-tab="about">
                <div class="about-game-content">
                  <?php if (!empty($game['long_description'])): ?>
                    <p><?= nl2br(htmlspecialchars($game['long_description'])) ?></p>
                  <?php else: ?>
                    <p class="empty-tab">No additional details yet.</p>
                  <?php endif; ?>
                  <?php if (!empty($game['features'])): ?>
                    <div class="feature-list">
                      <h4>FEATURES</h4>
                      <ul>
                        <?php foreach ($game['features'] as $f): ?>
                          <li><?= htmlspecialchars($f) ?></li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  <?php endif; ?>
                </div>
              </div>

              <!-- MEDIA TAB -->
              <?php if (!empty($game['screenshots'])): ?>
              <div class="tab-content" data-tab="media">
                <div class="screenshots-grid">
                  <?php foreach ($game['screenshots'] as $ss): ?>
                    <img src="<?= htmlspecialchars($ss) ?>" alt="Screenshot" class="screenshot" loading="lazy" />
                  <?php endforeach; ?>
                </div>
              </div>
              <?php endif; ?>
            </div>

            <!-- DOWNLOAD SECTION -->
            <div class="download-section">
              <?php if (!empty($game['download_links'])): ?>
                <div class="download-buttons">
                  <?php foreach ($game['download_links'] as $platform => $link): ?>
                    <?php if (!empty($link)): ?>
                    <a href="<?= htmlspecialchars($link) ?>" class="btn btn-download" target="_blank" rel="noopener">
                      <span class="dl-icon"><?= getPlatformIcon($platform) ?></span>
                      <?= strtoupper(htmlspecialchars($platform)) ?>
                    </a>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </div>
              <?php else: ?>
                <div class="coming-soon-dl">
                  <span class="cs-icon">⏳</span> Download coming soon
                </div>
              <?php endif; ?>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- ABOUT SECTION -->
<section class="section about-section" id="about">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">// DEV</span>
      <h2 class="section-title">ABOUT ME</h2>
      <div class="title-line"></div>
    </div>
    <div class="about-layout">
      <div class="about-avatar-wrap">
        <?php if (!empty($devInfo['avatar'])): ?>
          <img src="<?= htmlspecialchars($devInfo['avatar']) ?>" alt="Developer" class="about-avatar" />
        <?php else: ?>
          <div class="avatar-placeholder">
            <span>DEV</span>
          </div>
        <?php endif; ?>
        <div class="avatar-ring"></div>
      </div>
      <div class="about-text">
        <h3 class="about-name"><?= htmlspecialchars($devInfo['name'] ?? 'The Developer') ?></h3>
        <p class="about-role"><?= htmlspecialchars($devInfo['role'] ?? 'Indie Game Developer') ?></p>
        <div class="about-bio">
          <?= nl2br(htmlspecialchars($devInfo['bio'] ?? 'Passionate about creating games that push boundaries.')) ?>
        </div>
        <?php if (!empty($devInfo['skills'])): ?>
        <div class="about-skills">
          <?php foreach ($devInfo['skills'] as $skill): ?>
            <span class="skill-tag"><?= htmlspecialchars($skill) ?></span>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php if (!empty($devInfo['social'])): ?>
        <div class="about-socials">
          <?php foreach ($devInfo['social'] as $platform => $url): ?>
            <?php if (!empty($url)): ?>
            <a href="<?= htmlspecialchars($url) ?>" class="social-link" target="_blank" rel="noopener">
              <?= strtoupper(htmlspecialchars($platform)) ?>
            </a>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT SECTION -->
<section class="section contact-section" id="contact">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">// CONNECT</span>
      <h2 class="section-title">CONTACT</h2>
      <div class="title-line"></div>
    </div>
    <div class="contact-layout">
      <div class="contact-info">
        <?php if (!empty($devInfo['email'])): ?>
        <div class="contact-item">
          <span class="contact-label">EMAIL</span>
          <a href="mailto:<?= htmlspecialchars($devInfo['email']) ?>" class="contact-value"><?= htmlspecialchars($devInfo['email']) ?></a>
        </div>
        <?php endif; ?>
        <?php if (!empty($devInfo['discord'])): ?>
        <div class="contact-item">
          <span class="contact-label">DISCORD</span>
          <span class="contact-value"><?= htmlspecialchars($devInfo['discord']) ?></span>
        </div>
        <?php endif; ?>
        <p class="contact-note"><?= htmlspecialchars($devInfo['contact_note'] ?? 'Have feedback, bug reports, or just want to say hi? Reach out!') ?></p>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="container">
    <div class="footer-inner">
      <span class="footer-logo"><?= htmlspecialchars($devInfo['studio_name'] ?? 'DWYNREX') ?></span>
      <span class="footer-copy">© <?= date('Y') ?> — All rights reserved</span>
      <span class="footer-built">Built with passion &amp; caffeine</span>
    </div>
  </div>
</footer>

<script src="assets/js/main.js"></script>
</body>
</html>
