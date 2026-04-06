<?php
// ============================================
// BOT DE SUPERMERCADO - ISI504
// Autor: [Nombre del estudiante]
// Descripción: Bot que indica en qué pasillo 
// encontrar productos de un supermercado
// ============================================

// TOKEN de tu bot (obtenido de BotFather)
$token = "8693278632:AAE25CcvUvvlQ8G7q0Syz6rhUTbCBTaA2VQ";

// Recibir el mensaje que envía Telegram
$input = file_get_contents("php://input");

// Guardar en log (para evidenciar en el informe)
file_put_contents("log.txt", "Fecha: " . date("Y-m-d H:i:s") . " - Input: " . $input . PHP_EOL, FILE_APPEND);

// Decodificar el mensaje JSON
$update = json_decode($input, true);

// Obtener el ID del chat y el mensaje del usuario
$chatId = $update["message"]["chat"]["id"] ?? null;
$message = $update["message"]["text"] ?? "";

// Si no hay chatId, salir
if (!$chatId) {
    exit;
}

// Limpiar el mensaje (convertir a minúsculas y eliminar espacios)
$mensajeLimpio = trim(strtolower($message));

// ============================================
// LÓGICA DE RESPUESTA (PASILLOS DEL SUPERMERCADO)
// ============================================

// Respuesta por defecto (si no entiende)
$response = "❓ Lo siento, no entiendo la pregunta.\n\n";
$response .= "📋 *Productos disponibles:*\n";
$response .= "• Pasillo 1: Carne, Queso, Jamón\n";
$response .= "• Pasillo 2: Leche, Yogurth, Cereal\n";
$response .= "• Pasillo 3: Bebidas, Jugos\n";
$response .= "• Pasillo 4: Pan, Pasteles, Tortas\n";
$response .= "• Pasillo 5: Detergente, Lavaloza";

// Comando /start (bienvenida)
if ($mensajeLimpio == "/start") {
    $response = "🤖 *¡Bienvenido al Bot del Supermercado!*\n\n";
    $response .= "Pregúntame por un producto y te diré en qué pasillo encontrarlo.\n\n";
    $response .= "📋 *Productos disponibles:*\n";
    $response .= "• Pasillo 1: Carne, Queso, Jamón\n";
    $response .= "• Pasillo 2: Leche, Yogurth, Cereal\n";
    $response .= "• Pasillo 3: Bebidas, Jugos\n";
    $response .= "• Pasillo 4: Pan, Pasteles, Tortas\n";
    $response .= "• Pasillo 5: Detergente, Lavaloza";
}

// PASILLO 1: Carne, Queso, Jamón
elseif ($mensajeLimpio == "carne" || $mensajeLimpio == "queso" || $mensajeLimpio == "jamon") {
    $response = "✅ El producto *" . ucfirst($mensajeLimpio) . "* se encuentra en el *Pasillo 1*.";
}

// PASILLO 2: Leche, Yogurth, Cereal
elseif ($mensajeLimpio == "leche" || $mensajeLimpio == "yogurth" || $mensajeLimpio == "yogurt" || $mensajeLimpio == "cereal") {
    $response = "✅ El producto *" . ucfirst($mensajeLimpio) . "* se encuentra en el *Pasillo 2*.";
}

// PASILLO 3: Bebidas, Jugos
elseif ($mensajeLimpio == "bebidas" || $mensajeLimpio == "jugos") {
    $response = "✅ El producto *" . ucfirst($mensajeLimpio) . "* se encuentra en el *Pasillo 3*.";
}

// PASILLO 4: Pan, Pasteles, Tortas
elseif ($mensajeLimpio == "pan" || $mensajeLimpio == "pasteles" || $mensajeLimpio == "tortas") {
    $response = "✅ El producto *" . ucfirst($mensajeLimpio) . "* se encuentra en el *Pasillo 4*.";
}

// PASILLO 5: Detergente, Lavaloza
elseif ($mensajeLimpio == "detergente" || $mensajeLimpio == "lavaloza") {
    $response = "✅ El producto *" . ucfirst($mensajeLimpio) . "* se encuentra en el *Pasillo 5*.";
}

// ============================================
// ENVIAR RESPUESTA A TELEGRAM
// ============================================

// Llamar a la función para enviar el mensaje
enviarMensaje($chatId, $response, $token);

// ============================================
// FUNCIÓN PARA ENVIAR MENSAJES (cURL)
// ============================================

function enviarMensaje($chatId, $text, $token) {
    // URL de la API de Telegram
    $url = "https://api.telegram.org/bot" . $token . "/sendMessage";
    
    // Datos a enviar en formato JSON
    $data = json_encode([
        'chat_id' => $chatId,
        'text' => $text,
        'parse_mode' => 'Markdown'  // Para usar *negritas*
    ]);

    // Configurar cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Necesario para algunos hostings
    
    // Ejecutar
    $result = curl_exec($ch);
    
    // Guardar resultado en log
    file_put_contents("log.txt", "Resultado envío: " . $result . PHP_EOL, FILE_APPEND);
    
    // Cerrar conexión
    curl_close($ch);
}
?>
