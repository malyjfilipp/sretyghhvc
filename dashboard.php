<?php require 'config.php'; 

if (!isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$user = getDiscordUser();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Предложения по улучшению</title>
    <link rel="stylesheet" href="style.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('suggestion-form');
            const inputs = form.querySelectorAll('input, textarea, select');
            const submitBtn = document.getElementById('submit-btn');
            
            function checkForm() {
                let allFilled = true;
                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        allFilled = false;
                    }
                });
                
                submitBtn.disabled = !allFilled;
                submitBtn.style.backgroundColor = allFilled ? '#FFA500' : '#CC8400';
            }
            
            inputs.forEach(input => {
                input.addEventListener('input', checkForm);
                input.addEventListener('change', checkForm);
            });
            
            checkForm();
        });
    </script>
</head>
<body class="dashboard-page">
    <div class="dashboard-container">
        <div class="suggestion-box">
            <h2>Предложения по улучшению в СМИ</h2>
        </div>
        
        <form id="suggestion-form" action="submit_form.php" method="POST">
            <div class="form-box">
                <label>Ваш игровой ник:</label>
                <input type="text" name="game_name" class="form-input" placeholder="Введите ваш игровой ник">
            </div>
            
            <div class="form-box">
                <label>Суть предложения:</label>
                <select name="syti_vibor" class="form-input">
                    <option value="" selected disabled>Выберите тип предложения</option>
                    <option value="Изменение правила">Изменение правила</option>
                    <option value="Исправление/недоработок тем">Исправление/недоработок тем</option>
                </select>
            </div>
            
            <div class="form-box">
                <label>Суть улучшения:</label>
                <textarea name="up_zapoln" class="form-input large-input" placeholder="Опишите ваше предложение подробно"></textarea>
            </div>
            
            <button type="submit" id="submit-btn" class="submit-btn" disabled>Отправить предложение</button>
        </form>
    </div>
</body>
</html>
