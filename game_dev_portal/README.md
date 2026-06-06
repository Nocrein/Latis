# DWYNREX — Game Dev Portfolio Site

A dark cyberpunk-styled game developer portfolio site built with vanilla PHP + vanilla JS. No frameworks. No build step.

## Features
- Public site: hero, game cards, patch notes (tabbed), download buttons, about me, contact
- Admin panel: add/edit/delete games, add patch notes, edit dev profile
- JSON file-based storage (no database needed)
- Railway-ready deployment

## Local Development

```bash
php -S localhost:8080
```
Then open http://localhost:8080

## Admin Access
- URL: `/admin/login.php`
- Username: `admin`
- Password: `admin123`

> Change these via environment variables before going public.

## Deploy to Railway

### 1. Push to GitHub
```bash
git init
git add .
git commit -m "initial commit"
git remote add origin https://github.com/YOURUSERNAME/YOURREPO.git
git push -u origin main
```

### 2. Deploy on Railway
1. Go to https://railway.app → New Project → Deploy from GitHub
2. Select your repo
3. Railway auto-detects PHP via `nixpacks.toml`
4. It will deploy and give you a public URL

### 3. (Optional) Custom Domain
In Railway project settings → Domains → Add Custom Domain.

## Environment Variables (optional security)
Set these in Railway dashboard → Variables:
```
ADMIN_EMAIL=admin
ADMIN_PASS=your_secure_password_here
```

## File Structure
```
/
├── index.php              # Public homepage
├── admin/
│   ├── login.php
│   ├── index.php          # Dashboard
│   ├── game-new.php
│   ├── game-edit.php
│   ├── game-delete.php
│   ├── patch-new.php
│   ├── patch-delete.php
│   ├── dev-profile.php
│   └── logout.php
├── api/
│   ├── data.php           # Data helpers
│   └── auth.php           # Auth helpers
├── assets/
│   ├── css/main.css
│   ├── css/admin.css
│   └── js/main.js
├── data/                  # Auto-created, stores JSON files
├── railway.json
└── nixpacks.toml
```

## Notes
- The `data/` folder is in `.gitignore` — your content stays local/on Railway's filesystem.
- For persistent data on Railway: consider adding a volume or switching to a database.
- Images: use external URLs (Imgur, GitHub, CDN) for game covers and screenshots.
