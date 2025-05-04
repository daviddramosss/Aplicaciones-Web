<?php

namespace es\ucm\fdi\aw\helpers;

class iniciarPagoHelper
{
    public function __construct(){
    }  

    public function procesar()
    {
        if (!isset($_POST['importeTotal'])) {
            return "<p>Error: No se recibió el importe.</p>";
        }

        $importe = intval($_POST['importeTotal']);

        // URL dinámica
        $protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';

        $baseUrl = $protocolo . '://' . $host . $scriptDir;

        // DATOS DEL COMERCIO (sustituye por los reales)
        $claveSecreta = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7'; // Clave en Base64 (verifica en el portal Redsys)
        $codigoComercio = '999008881';
        $terminal = '01';
        $moneda = '978'; // Euros
        $urlOK = $baseUrl . 'confirmacionPago.php';
        $urlKO = $baseUrl . 'denegadoPago.php';
        $order = date('mdHis'); // Número único

        // 1. Preparar parámetros (sin espacios ni saltos de línea)
        $params = [
            'DS_MERCHANT_AMOUNT' => strval($importe),
            'DS_MERCHANT_ORDER' => $order,
            'DS_MERCHANT_MERCHANTCODE' => $codigoComercio,
            'DS_MERCHANT_CURRENCY' => $moneda,
            'DS_MERCHANT_TRANSACTIONTYPE' => '0', // 0 = Pago
            'DS_MERCHANT_TERMINAL' => $terminal,
            'DS_MERCHANT_URLOK' => $urlOK,
            'DS_MERCHANT_URLKO' => $urlKO
        ];

        $json = json_encode($params, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $base64Params = base64_encode($json);

        // 2. Generar firma
        $signature = $this->crearFirma($claveSecreta, $order, $base64Params);

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

    public static function crearFirma($claveSecreta, $order, $base64Params)
    {
        $claveDerivada = self::encrypt_3DES($order, $claveSecreta);
        $hash = hash_hmac('sha256', $base64Params, $claveDerivada, true);
        return base64_encode($hash);
    }

    private static function encrypt_3DES($message, $key)
    {
        $key = base64_decode($key);
        $iv = "\x00\x00\x00\x00\x00\x00\x00\x00"; // 8 bytes
        $l = ceil(strlen($message) / 8) * 8;
        $messagePadded = str_pad($message, $l, "\0");
        return openssl_encrypt($messagePadded, 'des-ede3-cbc', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
    }

}