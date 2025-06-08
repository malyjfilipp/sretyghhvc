<?php
// Конфигурация Discord OAuth2
define('DISCORD_CLIENT_ID', '1379206981360943106');
define('DISCORD_CLIENT_SECRET', 'u2XqtlONhjuCXy1hZ6MG00ezGpw_CRi5');
define('DISCORD_REDIRECT_URI', 'https://testmassmedia.great-site.net/discord_auth.php');
define('DISCORD_BOT_TOKEN', 'MTM3OTIwNjk4MTM2MDk0MzEwNg.GVdcj-.WmLWhpCbu9qlUU0tnVFSgxt9AI6O8812vQbH0c');
define('DISCORD_WEBHOOK_URL', 'https://discord.com/api/webhooks/1380887787313692672/iGBVzMd_nRhzikVjJcCxyQHqTYEN_gtRaGMOaBPCbXT_V5wXuRoq3FhO4TUp4YRQLw5q');

// Конфигурация базы данных
define('DB_HOST', 'sql113.infinityfree.com');
define('DB_USER', 'if0_39176701');
define('DB_PASS', 'wTyRsCggprvvPT');
define('DB_NAME', 'if0_39176701_test');

// Инициализация сессии
session_start();

// Подключение к базе данных
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Функция для проверки авторизации
function isLoggedIn() {
    return isset($_SESSION['discord_user']);
}

// Функция для получения Discord пользователя
function getDiscordUser() {
    return $_SESSION['discord_user'] ?? null;
}
?>
