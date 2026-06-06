<?php
require_once '../api/auth.php';
require_once '../api/data.php';
requireLogin();

$gameId = $_GET['game'] ?? '';
$index  = (int)($_GET['index'] ?? -1);
$games  = getGames();
foreach ($games as &$g) {
    if ($g['id'] === $gameId && isset($g['patch_notes'][$index])) {
        array_splice($g['patch_notes'], $index, 1);
        break;
    }
}
saveGames($games);
header('Location: game-edit.php?id=' . urlencode($gameId));
exit;
