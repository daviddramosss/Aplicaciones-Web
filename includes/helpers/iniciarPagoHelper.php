<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\helpers\firmaHelper;


class iniciarPagoHelper
{
    public function procesar(): string
    {
        if (!isset($_POST['importeTotal'])) {
            return "<p>Error: No se recibió el importe.</p>";
        }

        $importe = intval($_POST['importeTotal']);

        // DATOS DEL COMERCIO (sustituye por los reales)
        $claveSecreta = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7'; // Clave en Base64 (verifica en el portal Redsys)
        $codigoComercio = '999008881';
        $terminal = '01';
        $moneda = '978'; // Euros
        $urlOK = 'http://localhost/AW/MarketChef/confirmacionPago.php';
        $urlKO = 'http://localhost/AW/MarketChef/denegadoPago.php';
        $urlNotificacion = 'http://localhost/AW/MarketChef/notificacionPago.php';
        $order = date('mdHis'); // Número único

        // 1. Preparar parámetros (sin espacios ni saltos de línea)
        $params = [
            'DS_MERCHANT_AMOUNT' => strval($importe),
            'DS_MERCHANT_ORDER' => $order,
            'DS_MERCHANT_MERCHANTCODE' => $codigoComercio,
            'DS_MERCHANT_CURRENCY' => $moneda,
            'DS_MERCHANT_TRANSACTIONTYPE' => '0', // 0 = Pago
            'DS_MERCHANT_TERMINAL' => $terminal,
            'DS_MERCHANT_MERCHANTURL' => $urlNotificacion,
            'DS_MERCHANT_URLOK' => $urlOK,
            'DS_MERCHANT_URLKO' => $urlKO
        ];

        $json = json_encode($params, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $base64Params = base64_encode($json);

        // 2. Generar firma
        $signature = firmaHelper::crearFirma($claveSecreta, $order, $base64Params);

        // 3. Formulario a Redsys
        return <<<HTML
            <form id="pagoRedsys" action="https://sis-t.redsys.es:25443/sis/realizarPago" method="POST">
                <input type="hidden" name="Ds_SignatureVersion" value="HMAC_SHA256_V1">
                <input type="hidden" name="Ds_MerchantParameters" value="$base64Params">
                <input type="hidden" name="Ds_Signature" value="$signature">
                <p>Redirigiendo a Redsys...</p>
            </form>
            <script>document.getElementById('pagoRedsys').submit();</script>
        HTML;
    }

}