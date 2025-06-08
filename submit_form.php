<?php
require 'config.php';

if (!isLoggedIn() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

$user = getDiscordUser();
$game_name = $db->real_escape_string($_POST['game_name'] ?? '');
$suggestion_type = $db->real_escape_string($_POST['syti_vibor'] ?? '');
$improvement = $db->real_escape_string($_POST['up_zapoln'] ?? '');

// Сохраняем в базу данных
$query = "INSERT INTO suggestions (discord_id, game_name, suggestion_type, improvement_details) 
          VALUES ('{$user['id']}', '$game_name', '$suggestion_type', '$improvement')";
$db->query($query);

// Отправляем в Discord через вебхук
$webhook_data = [
    'username' => 'Система предложений',
    'embeds' => [
        [
            'title' => 'Новое предложение',
            'color' => hexdec('FFA500'),
            'fields' => [
                [
                    'name' => 'Discord пользователь',
                    'value' => "{$user['username']}#{$user['discriminator']} ({$user['id']})",
                    'inline' => true
                ],
                [
                    'name' => 'Игровой ник',
                    'value' => $game_name,
                    'inline' => true
                ],
                [
                    'name' => 'Тип предложения',
                    'value' => $suggestion_type,
                    'inline' => true
                ],
                [
                    'name' => 'Описание улучшения',
                    'value' => $improvement,
                    'inline' => false
                ]
            ],
            'timestamp' => date('c')
        ]
    ]
];

$options = [
    'http' => [
        'header' => "Content-type: application/json\r\n",
        'method' => 'POST',
        'content' => json_encode($webhook_data)
    ]
];

$context = stream_context_create($options);
file_get_contents(DISCORD_WEBHOOK_URL, false, $context);

// Перенаправляем обратно с сообщением об успехе
header('Location: dashboard.php?success=1');
exit();
?>