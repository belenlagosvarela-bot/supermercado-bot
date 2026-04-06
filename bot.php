<?php
// Token de tu bot
$token = "8693278632:AAE25CcvUvvlQ8G7q0Syz6rhUTbCBTaA2VQ";

// Recibir el mensaje de Telegram
$input = file_get_contents("php://input");
file_put_contents("log.txt", "Fecha: " . date("Y-m-d H:i:s") . " - Input: " . $input . PHP_EOL, FILE_APPEND);

$update = json_decode($input, true);
$chatId = $update["message"]["chat"]["id"] ?? null;
$message = $update["message"]["text"] ?? "";

if (!$chatId) {
    exit;
}

$mensajeLimpio = trim(strtolower($message));

// Lógica de respuesta
if ($mensajeLimpio == "/start") {
    $response = "🤖 ¡Bienvenido al Bot del Supermercado! ¿Necesitas ayuda para encontrar algo? Pregúntame por un producto y te diré en qué pasillo está.";
} 
elseif ($mensajeLimpio == "carne" || $mensajeLimpio == "queso" || $mensajeLimpio == "jamon") {
    $response = "✅ El producto *" . ucfirst($mensajeLimpio) . "* se encuentra en el *Pasillo 1*.";
} 
elseif ($mensajeLimpio == "leche" || $mensajeLimpio == "yogurth" || $mensajeLimpio == "yogurt" || $mensajeLimpio == "cereal") {
    $response = "✅ El producto *" . ucfirst($mensajeLimpio) . "* se encuentra en el *Pasillo 2*.";
} 
elseif ($mensajeLimpio == "bebidas" || $mensajeLimpio == "jugos") {
    $response = "✅ El producto *" . ucfirst($mensajeLimpio) . "* se encuentra en el *Pasillo 3*.";
} 
elseif ($mensajeLimpio == "pan" || $mensajeLimpio == "pasteles" || $mensajeLimpio == "tortas") {
    $response = "✅ El producto *" . ucfirst($mensajeLimpio) . "* se encuentra en el *Pasillo 4*.";
} 
elseif ($mensajeLimpio == "detergente" || $mensajeLimpio == "lavaloza") {
    $response = "✅ El producto *" . ucfirst($mensajeLimpio) . "* se encuentra en el *Pasillo 5*.";
} 
else {
    $response = "❌ No tengo registro de ese producto en el supermercado. ¿Puedo ayudarte a buscar algo más?";
}

enviarMensaje($chatId, $response, $token);

function enviarMensaje($chatId, $text, $token) {
    $url = "https://api.telegram.org/bot" . $token . "/sendMessage";
    
    $data = json_encode([
        'chat_id' => $chatId,
        'text' => $text,
        'parse_mode' => 'Markdown'
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $result = curl_exec($ch);
    file_put_contents("log.txt", "Resultado envío: " . $result . PHP_EOL, FILE_APPEND);
    curl_close($ch);
}
?>
