<?php
require_once '../api/auth.php';
require_once '../api/data.php';
requireLogin();

$id = $_GET['id'] ?? '';
$games = getGames();
$games = array_values(array_filter($games, fn($g) => $g['id'] !== $id));
saveGames($games);
header('Location: index.php?deleted=1');
exit;
