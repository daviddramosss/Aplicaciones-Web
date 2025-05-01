<?php

include_once("includes/lib/ApiRedsysREST/initRedsysApi.php");

class IniciarPagoHelper {

    private $signatureKey = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';
    private $merchantCode = '999008881';
    private $terminal = '20';
    private $amount = '123'; // 1,23€
    private $currency = '978'; // Euro
    private $sandboxEnv;

    public function __construct() {
        $this->sandboxEnv = RESTConstants::$ENV_SANDBOX;
    }
    public function procesar() {
        $orderID = $this->generarOrderId();

        if (empty($_GET)) {
            $this->initialOperationV1($orderID);
        } elseif (!empty($_POST)) {
            if ($_GET['urlOK'] == 'yes' && isset($_GET['ope'])) {
                $operation = unserialize(base64_decode(strtr($_GET['ope'], '-_', '+/')));
                $this->challengeRequestV1($operation);
            }
        }
    }

    private function generarOrderId() {
        return substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 10)), 0, 12);
    }

    private function initialOperationV1($orderID) {
        $request = new RESTInitialRequestMessage();
        $request->setAmount($this->amount);
        $request->setCurrency($this->currency);
        $request->setMerchant($this->merchantCode);
        $request->setTerminal($this->terminal);
        $request->setOrder($orderID);
        $request->setTransactionType(RESTConstants::$AUTHORIZATION);
        $request->setCardNumber("4548810000000003");
        $request->setCardExpiryDate("4912");
        $request->setCvv2("123");
        $request->addParameter("DS_MERCHANT_PRODUCTDESCRIPTION", "Prueba de pago InSite con 3DSecure");
        $request->demandCardData();

        $service = new RESTInitialRequestService($this->signatureKey, $this->sandboxEnv);
        $response = $service->sendOperation($request);

        switch ($response->getResult()) {
            case RESTConstants::$RESP_LITERAL_OK:
                $this->authenticationOperationV1($request, '');
                break;

            case RESTConstants::$RESP_LITERAL_AUT:
                $protocolVersion = $response->protocolVersionAnalysis();
                $this->authenticationOperationV1($request, $protocolVersion);
                break;

            default:
                echo "<h1>Error en la operación inicial</h1>";
        }
    }

    private function authenticationOperationV1($request, $protocolVersion) {
        $authRequest = new RESTOperationMessage();
        $authRequest->setAmount($request->getAmount());
        $authRequest->setCurrency($request->getCurrency());
        $authRequest->setMerchant($request->getMerchant());
        $authRequest->setTerminal($request->getTerminal());
        $authRequest->setOrder($request->getOrder());
        $authRequest->setTransactionType(RESTConstants::$AUTHORIZATION);
        $authRequest->setCardNumber("4548810000000003");
        $authRequest->setCardExpiryDate("4912");
        $authRequest->setCvv2("123");
        $authRequest->setEMV3DSParamsV1();


        $service = new RESTOperationService($this->signatureKey, $this->sandboxEnv);
        $response = $service->sendOperation($authRequest);

        if ($response->getResult() === RESTConstants::$RESP_LITERAL_AUT) {
            $ope = strtr(base64_encode(serialize($response->getOperation())), '+/', '-_');
            $this->mostrarFormularioChallenge($response, $ope);
        } elseif ($response->getResult() === RESTConstants::$RESP_LITERAL_OK) {
            echo "<h1>Autenticación completada sin fricción</h1>";
        } else {
            echo "<h1>Fallo en la autenticación</h1>";
            echo "<p>Resultado: " . $response->getResult() . "</p>";
            echo "<pre>";
            var_dump($response);
            echo "</pre>";
        }
    }

    private function mostrarFormularioChallenge($response, $ope) {
        $acsURL = $response->getAcsURLParameter();
        $pAReq = $response->getPAReqParameter();
        $md = $response->getMDParameter();
        $termUrl = "http://localhost/ejemplosAPIREST/Example3DSecureV1Reference.php?urlOK=yes&ope={$ope}";

        echo <<<HTML
    <iframe name="redsys_iframe_acs" id="redsys_iframe_acs"
            sandbox="allow-same-origin allow-scripts allow-top-navigation allow-forms"
            style="border: none; display: none;" height="95%" width="100%"></iframe>

    <form name="redsysAcsForm" id="redsysAcsForm" action="{$acsURL}" method="POST" target="redsys_iframe_acs">
        <input type="hidden" name="PaReq" value="{$pAReq}">
        <input type="hidden" name="TermUrl" value="{$termUrl}">
        <input type="hidden" name="MD" value="{$md}">
        <p style="font-family: Arial; font-size: 16px; font-weight: bold;">Conectando con el emisor...</p>
    </form>

    <script>
        window.onload = function () {
            document.getElementById("redsys_iframe_acs").onload = function() {
                document.getElementById("redsysAcsForm").style.display = "none";
                document.getElementById("redsys_iframe_acs").style.display = "inline";
            };
            document.redsysAcsForm.submit();
        };
    </script>
    HTML;
    }

    private function challengeRequestV1($operation) {
        $service = new RESTService($this->signatureKey, $this->sandboxEnv, $operation);
        $response = $service->sendOperation($operation);

        echo "<h1>CHALLENGE: Respuesta</h1>";
        var_dump($response);

        if ($response->getResult() === RESTConstants::$RESP_LITERAL_OK) {
            echo "<h1>Pago completado correctamente</h1>";
        } else {
            echo "<h1>Fallo en el desafío</h1>";
        }
    }
}
