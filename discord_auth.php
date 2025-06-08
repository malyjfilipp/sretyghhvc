<?php
require 'config.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    
    // Получаем access token
    $token_url = 'https://discord.com/api/oauth2/token';
    $data = [
        'client_id' => DISCORD_CLIENT_ID,
        'client_secret' => DISCORD_CLIENT_SECRET,
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => DISCORD_REDIRECT_URI,
        'scope' => 'identify'
    ];
    
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($token_url, false, $context);
    $response = json_decode($result, true);
    
    if (isset($response['access_token'])) {
        $access_token = $response['access_token'];
        
        // Получаем информацию о пользователе
        $user_url = 'https://discord.com/api/users/@me';
        $options = [
            'http' => [
                'header' => "Authorization: Bearer $access_token\r\n",
                'method' => 'GET'
            ]
        ];
        
        $context = stream_context_create($options);
        $user_result = file_get_contents($user_url, false, $context);
        $user = json_decode($user_result, true);
        
        if (isset($user['id'])) {
            // Сохраняем пользователя в сессии
            $_SESSION['discord_user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'discriminator' => $user['discriminator'],
                'avatar' => $user['avatar'] ?? null
            ];
            
            // Сохраняем в куки на 30 дней
            setcookie('discord_user_id', $user['id'], time() + (86400 * 30), "/");
            
            // Перенаправляем на dashboard
            header('Location: dashboard.php');
            exit();
        }
    }
}

// Если что-то пошло не так, перенаправляем на главную
header('Location: index.php');
exit();
?>