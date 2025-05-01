<?php

include_once("includes/lib/ApiRedsysREST/initRedsysApi.php");

class iniciarPagoHelper
{
    public function generarFormularioPago(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $importe = $_POST['importeTotal'] ?? null;

        // Validar importe
        if (!$importe || !is_numeric($importe) || $importe <= 0) {
            return "<p>Error: Importe no válido.</p>";
        }

        // Convertir importe a formato de Redsys
        $importeEnCentimos = (int)round(floatval($importe) * 100);

        // Configuración Redsys (modo pruebas)
        $claveFirma = "sq7HjrUOBfKmC576ILgskD5srU870gJ7";
        $entorno = RESTConstants::$ENV_SANDBOX;
        $fuc = "999008881";
        $terminal = "1";
        $moneda = "978";
        $order = uniqid("ORD");
        $transaccion = "0"; // Autorización
        $urlOk = "http://localhost/tu-proyecto/pagoOk.php";
        $urlKo = "http://localhost/tu-proyecto/pagoKo.php";

        // Crear mensaje de inicio
        $message = new RESTInitialRequestMessage();
        $message
            ->setAmount($importeEnCentimos)
            ->setCurrency($moneda)
            ->setOrder($order)
            ->setMerchant($fuc)
            ->setTerminal($terminal)
            ->setTransactionType($transaccion)
            ->setMerchantURL($urlOk)
            ->setUrlKO($urlKo)
            ->setUrlOK($urlOk);

        // Instanciar servicio
        $servicio = new RESTInitialRequestService($claveFirma, $entorno);
        $response = $servicio->sendInitialRequest($message);

        // Analizar respuesta
        if ($response->getResult() === "OK") {
            $op = $response->getOperation();
            $url = htmlspecialchars($op->getUrl());
            $params = htmlspecialchars($op->getMerchantParameters());
            $signature = htmlspecialchars($op->getSignature());
            $signatureVersion = htmlspecialchars($op->getSignatureVersion());

            return <<<HTML
                <p>Redirigiendo a Redsys para completar el pago...</p>
                <form id="formPago" action="$url" method="post">
                    <input type="hidden" name="Ds_MerchantParameters" value="$params">
                    <input type="hidden" name="Ds_SignatureVersion" value="$signatureVersion">
                    <input type="hidden" name="Ds_Signature" value="$signature">
                    <noscript><button type="submit">Ir a Redsys</button></noscript>
                </form>
                <script>document.getElementById("formPago").submit();</script>
            HTML;
        } else {
            $errorCode = htmlspecialchars($response->getApiCode());
            $errorMessage = htmlspecialchars($response->getErrorMessage() ?? 'Error desconocido');
            return "<p>Error al iniciar el pago. Código: $errorCode. Mensaje: $errorMessage</p>";
        }
    }
}
