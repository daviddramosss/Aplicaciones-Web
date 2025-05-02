<?php

use es\ucm\fdi\aw\helpers\firmaHelper;


require_once("includes/config.php");

// Clave secreta del comercio (base64, misma que en iniciarPagoHelper)
$claveSecreta = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';

// Recupera los datos POST enviados por Redsys
$version = $_POST['Ds_SignatureVersion'] ?? null;
$datos = $_POST['Ds_MerchantParameters'] ?? null;
$firmaRedsys = $_POST['Ds_Signature'] ?? null;

if ($version && $datos && $firmaRedsys) {
    $json = base64_decode($datos);
    $params = json_decode($json, true);
    $order = $params['Ds_Order'] ?? '';

    // Recalcula la firma con la misma lógica que en iniciarPagoHelper
    $firmaCalculada = firmaHelper::crearFirma($claveSecreta, $order, $datos);

    // Compara las firmas (cuidado con mayúsculas/minúsculas)
    if ($firmaCalculada === $firmaRedsys) {
        // Firma válida: procesar según resultado del pago
        $resultado = intval($params['Ds_Response'] ?? -1);

        if ($resultado < 100) {
            // Pago correcto
            error_log("Pago correcto para pedido $order");
        } else {
            // Pago denegado
            error_log("Pago fallido para pedido $order - Código: $resultado");
        }
    } else {
        // Firma incorrecta
        error_log("Firma incorrecta en notificación para pedido $order");
    }
} else {
    error_log("Notificación Redsys incompleta o inválida.");
}

// Siempre responde con 200 OK
http_response_code(200);
exit;
