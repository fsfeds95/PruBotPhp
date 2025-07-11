<?php

$token = "7723354766:AAEohsyBpMP8ZeTV3MwnJU7ghIK73cWf83o"; // Reemplaza esto

// Recibimos la info enviada por Telegram (JSON)
$content = file_get_contents("php://input");
$update = json_decode($content, true);

// Verificamos si hay mensaje
if (isset($update["message"])) {
    $chat_id = $update["message"]["chat"]["id"];
    $mensaje = $update["message"]["text"];

    if ($mensaje == "/start") {
        enviarMensaje($chat_id, "¡Hola! Soy tu bot en PHP 😎");
    } else {
        enviarMensaje($chat_id, "Dijiste: " . $mensaje);
    }
}

// Función para enviar mensajes
function enviarMensaje($chat_id, $texto) {
    $token = "TU_TOKEN_DEL_BOT";
    $url = "https://api.telegram.org/bot$token/sendMessage";

    $datos = [
        'chat_id' => $chat_id,
        'text' => $texto,
    ];

    // Enviar petición POST con cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_exec($ch);
    curl_close($ch);
}
?>