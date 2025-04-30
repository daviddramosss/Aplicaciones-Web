<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\lib\redsys\Model\element\RESTOperationElement;
use es\ucm\fdi\aw\lib\redsys\Constants\RESTConstants;
use es\ucm\fdi\aw\lib\redsys\Model\message\RESTOperationMessage;
use es\ucm\fdi\aw\lib\redsys\Service\Impl\RESTOperationService;

class iniciarPagoHelper
{
    public function generarFormularioPago(): string
    {
        if (!isset($_SESSION)) session_start();

        $importe = $_POST['importeTotal'] ?? null;

        if (!$importe || !is_numeric($importe)) {
            return "<p>Error: Importe no válido.</p>";
        }

        // Configuración de Redsys en modo prueba
        $claveFirma = "sq7HjrUOBfKmC576ILgskD5srU870gJ7";
        $entorno = RESTConstants::$ENV_SANDBOX;
        $fuc = "999008881";
        $terminal = "1";
        $order = uniqid();
        $urlOk = "http://localhost/tu-proyecto/pagoOk.php";
        $urlKo = "http://localhost/tu-proyecto/pagoKo.php";

        // Crear objeto operación con setters
        $operation = new RESTOperationElement();
        $operation
            ->setAmount($importe)
            ->setCurrency("978")
            ->setOrder($order)
            ->setMerchant($fuc)
            ->setTerminal($terminal)
            ->setTransactionType("AUTHORIZATION");


        $message = new RESTOperationMessage();
        $message
            ->setAmount($operation->getAmount())
            ->setCurrency($operation->getCurrency())
            ->setOrder($operation->getOrder())
            ->setMerchant($operation->getMerchant())
            ->setTerminal($operation->getTerminal())
            ->setTransactionType($operation->getTransactionType());
            

        $servicio = new RESTOperationService($claveFirma, $entorno);
        $response = $servicio->sendOperation($message);

        if ($response->result === "OK" && isset($response->operation->url)) {
            $url = htmlspecialchars($response->operation->url);
            $params = htmlspecialchars($response->operation->merchantParameters);
            $signature = htmlspecialchars($response->operation->signature);
            $signatureVersion = htmlspecialchars($response->operation->signatureVersion);

            return <<<HTML
                <p>Redirigiendo a Redsys para completar el pago...</p>
                <form id="formPago" action="$url" method="post">
                    <input type="hidden" name="Ds_MerchantParameters" value="$params">
                    <input type="hidden" name="Ds_SignatureVersion" value="$signatureVersion">
                    <input type="hidden" name="Ds_Signature" value="$signature">
                    <button type="submit">Ir a Redsys</button>
                </form>
                <script>document.getElementById("formPago").submit();</script>
            HTML;
        } else {
            return "<p>Error al iniciar el pago. Código: {$response->apiCode}</p>";
        }
    }
}
