<?php
define('DATA_DIR', __DIR__ . '/../data/');
define('GAMES_FILE', DATA_DIR . 'games.json');
define('DEV_FILE', DATA_DIR . 'dev.json');
define('SITE_FILE', DATA_DIR . 'site.json');

function getPlatformIcon($platform) {
    $icons = [
        'windows' => '⊞',
        'linux'   => '🐧',
        'mac'     => '⌘',
        'android' => '◉',
        'web'     => '🌐',
        'itch'    => '◈',
        'github'  => '⌂',
    ];
    return $icons[strtolower($platform)] ?? '↓';
}

function getGames() {
    if (!file_exists(GAMES_FILE)) return [];
    $data = json_decode(file_get_contents(GAMES_FILE), true);
    return $data ?? [];
}

function saveGames($games) {
    file_put_contents(GAMES_FILE, json_encode($games, JSON_PRETTY_PRINT));
}

function getGame($id) {
    $games = getGames();
    foreach ($games as $g) {
        if ($g['id'] === $id) return $g;
    }
    return null;
}

function getDevInfo() {
    if (!file_exists(DEV_FILE)) return getDefaultDevInfo();
    $data = json_decode(file_get_contents(DEV_FILE), true);
    return $data ?? getDefaultDevInfo();
}

function saveDevInfo($info) {
    file_put_contents(DEV_FILE, json_encode($info, JSON_PRETTY_PRINT));
}

function getSiteData() {
    if (!file_exists(SITE_FILE)) return [];
    $data = json_decode(file_get_contents(SITE_FILE), true);
    return $data ?? [];
}

function getDefaultDevInfo() {
    return [
        'name'            => 'The Developer',
        'studio_name'     => 'DWYNREX',
        'tagline'         => 'INDIE GAME STUDIO',
        'role'            => 'Indie Game Developer',
        'hero_description'=> 'Crafting immersive experiences from the ground up. Independent. Relentless. Evolving.',
        'bio'             => 'Passionate solo developer building the games I always wanted to play.',
        'email'           => '',
        'discord'         => '',
        'avatar'          => '',
        'skills'          => ['Unity', 'Godot', 'Pixel Art', 'Game Design'],
        'social'          => ['twitter' => '', 'github' => '', 'itch' => ''],
        'contact_note'    => 'Have feedback, bug reports, or just want to say hi? Reach out!',
    ];
}

function initData() {
    if (!is_dir(DATA_DIR)) mkdir(DATA_DIR, 0755, true);
    if (!file_exists(GAMES_FILE)) {
        $demo = [[
            'id'             => 'game-001',
            'title'          => 'SAMPLE GAME',
            'genre'          => 'Action RPG',
            'status'         => 'active',
            'latest_version' => '0.2.0',
            'description'    => 'An immersive experience that pushes the boundaries of independent game development.',
            'long_description'=> "This is a demo game entry. Edit it from the admin panel.\n\nReplace this with your actual game description.",
            'features'       => ['Open world exploration', 'Tactical combat system', 'Rich lore'],
            'cover_image'    => '',
            'screenshots'    => [],
            'download_links' => ['windows' => '', 'linux' => '', 'itch' => ''],
            'patch_notes'    => [
                [
                    'version' => '0.1.0',
                    'date'    => date('M j, Y'),
                    'tag'     => 'Initial Release',
                    'changes' => ['First public build', 'Core gameplay loop implemented', 'Basic enemy AI'],
                ],
                [
                    'version' => '0.2.0',
                    'date'    => date('M j, Y'),
                    'tag'     => 'Latest Release',
                    'changes' => ['Performance improvements', 'New area: The Forgotten Citadel', 'Bug fixes'],
                ],
            ],
            'created_at' => date('Y-m-d'),
        ]];
        file_put_contents(GAMES_FILE, json_encode($demo, JSON_PRETTY_PRINT));
    }
    if (!file_exists(DEV_FILE)) {
        file_put_contents(DEV_FILE, json_encode(getDefaultDevInfo(), JSON_PRETTY_PRINT));
    }
}

initData();
