<?php

$token = "7723354766:AAEohsyBpMP8ZeTV3MwnJU7ghIK73cWf83o"; // Reemplaza esto

file_put_contents("log.txt", file_get_contents("php://input") . PHP_EOL, FILE_APPEND);

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (isset($update["message"])) {
    $chat_id = $update["message"]["chat"]["id"];
    $mensaje = $update["message"]["text"];

    if ($mensaje == "/start") {
        enviarMensaje($chat_id, "¡Hola! Soy tu bot en Render 😎");
    } else {
        enviarMensaje($chat_id, "Dijiste: " . $mensaje);
    }
}

function enviarMensaje($chat_id, $texto) {
    global $token;
    $url = "https://api.telegram.org/bot$token/sendMessage";

    $datos = [
        'chat_id' => $chat_id,
        'text' => $texto,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if ($response === false) {
        file_put_contents("log.txt", "❌ Error cURL: " . curl_error($ch) . PHP_EOL, FILE_APPEND);
    } else {
        file_put_contents("log.txt", "✅ Telegram dice: " . $response . PHP_EOL, FILE_APPEND);
    }

    curl_close($ch);
}