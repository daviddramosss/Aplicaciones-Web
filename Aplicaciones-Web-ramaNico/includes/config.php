<?php
use es\ucm\fdi\aw\application;

define('BD_HOST', 'localhost');
define('BD_NAME', 'marketchefn');
define('BD_USER', 'MarketChef');
define('BD_PASS', 'MarketChef');

ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

// Iniciar sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

spl_autoload_register(function ($class) {
    $prefix = 'es\\ucm\\fdi\\aw\\';
    $base_dir = __DIR__ . '/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    } else {
        error_log("Clase '$class' no encontrada en '$file'");
    }
});

$app = application::getInstance();
$app->init(['host' => BD_HOST, 'bd' => BD_NAME, 'user' => BD_USER, 'pass' => BD_PASS]);

register_shutdown_function([$app, 'shutdown']);

function gestorExcepciones(Throwable $exception) {
    error_log(jTraceEx($exception));
    http_response_code(500);
    $tituloPagina = 'Error';
    $contenidoPrincipal = <<<EOS
    <h1>Oops</h1>
    <p>Parece que ha habido un fallo.</p>
    EOS;
    require("comun/plantilla.php");
}

function jTraceEx($e, $seen = null) {
    $starter = $seen ? 'Caused by: ' : '';
    $result = [];
    if (!$seen) $seen = [];
    $trace = $e->getTrace();
    $prev = $e->getPrevious();
    $result[] = sprintf('%s%s: %s', $starter, get_class($e), $e->getMessage());
    $file = $e->getFile();
    $line = $e->getLine();
    while (true) {
        $current = "$file:$line";
        if (is_array($seen) && in_array($current, $seen)) {
            $result[] = sprintf(' ... %d more', count($trace) + 1);
            break;
        }
        $result[] = sprintf(' at %s%s%s(%s%s%s)',
            count($trace) && array_key_exists('class', $trace[0]) ? str_replace('\\', '.', $trace[0]['class']) : '',
            count($trace) && array_key_exists('class', $trace[0]) && array_key_exists('function', $trace[0]) ? '.' : '',
            count($trace) && array_key_exists('function', $trace[0]) ? str_replace('\\', '.', $trace[0]['function']) : '(main)',
            $line === null ? $file : basename($file),
            $line === null ? '' : ':',
            $line === null ? '' : $line);
        if (is_array($seen)) {
            $seen[] = "$file:$line";
        }
        if (!count($trace)) {
            break;
        }
        $file = array_key_exists('file', $trace[0]) ? $trace[0]['file'] : 'Unknown Source';
        $line = array_key_exists('file', $trace[0]) && array_key_exists('line', $trace[0]) && $trace[0]['line'] ? $trace[0]['line'] : null;
        array_shift($trace);
    }
    $result = join(PHP_EOL, $result);
    if ($prev) {
        $result .= PHP_EOL . jTraceEx($prev, $seen);
    }
    return $result;
}