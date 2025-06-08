<?php 
// Включение отображения ошибок для диагностики
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Проверка существования config.php
if (!file_exists('config.php')) {
    die('Файл конфигурации не найден. Пожалуйста, создайте config.php');
}

require 'config.php';

// Проверка наличия необходимых констант
if (!defined('DISCORD_CLIENT_ID') || !defined('DISCORD_REDIRECT_URI')) {
    die('Не настроены параметры Discord OAuth. Проверьте config.php');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход через Discord</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Временные стили на случай отсутствия style.css */
        body.auth-page {
            background-color: #b0b0b0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }
        .auth-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }
        .auth-box {
            background-color: #2c2f33;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .auth-box h1 {
            color: white;
            margin-bottom: 20px;
        }
        .discord-login-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #5865F2;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .discord-login-btn:hover {
            background-color: #4752c4;
        }
        .discord-logo {
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }
    </style>
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-box">
            <h1>Добро пожаловать</h1>
            <a href="https://discord.com/api/oauth2/authorize?client_id=<?php echo htmlspecialchars(DISCORD_CLIENT_ID); ?>&redirect_uri=<?php echo htmlspecialchars(urlencode(DISCORD_REDIRECT_URI)); ?>&response_type=code&scope=identify" 
   class="discord-login-btn">
   <img src="discord.png" alt="Discord Logo" class="discord-logo">
   Войти через Discord
            </a>
        </div>
    </div>
</body>
</html>
