<?php

require_once("application.php");

define('BD_HOST', 'localhost');
define('BD_NAME', 'MarketChef');
define('BD_USER', 'MarketChef');
define('BD_PASS', 'MarketChef');

ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

$app = application::getInstance();

$app->init(array('host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS));

register_shutdown_function([$app, 'shutdown']);

function getConexionBD() 
{
  global $BD;
  
  if (!$BD) 
  {
    $BD = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);
    
    if ( $BD->connect_errno ) 
    {
      echo "Error de conexión a la BD: (" . $BD->connect_errno . ") " . $BD->connect_error;
      exit();
    }
    
    if ( ! $BD->set_charset("utf8mb4")) 
    {
      echo "Error al configurar la codificación de la BD: (" . $BD->errno . ") " . $BD->error;
      exit();
    }
  }

  return $BD;
}

function gestorExcepciones(Throwable $exception) 
{
    error_log(jTraceEx($exception)); 

    http_response_code(500);

    $tituloPagina = 'Error';

    $contenidoPrincipal = <<<EOS
    <h1>Oops</h1>
    <p> Parece que ha habido un fallo.</p>
    EOS;

    require("comun/plantilla.php");
}

//set_exception_handler('gestorExcepciones');

// http://php.net/manual/es/exception.gettraceasstring.php#114980
/**
 * jTraceEx() - provide a Java style exception trace
 * @param Throwable $exception
 * @param string[] $seen Array passed to recursive calls to accumulate trace lines already seen leave as NULL when calling this function
 * @return string  string stack trace, one entry per trace line
 */
function jTraceEx($e, $seen=null) 
{
    $starter = $seen ? 'Caused by: ' : '';
    $result = array();
    if (!$seen) $seen = array();
    $trace  = $e->getTrace();
    $prev   = $e->getPrevious();
    $result[] = sprintf('%s%s: %s', $starter, get_class($e), $e->getMessage());
    $file = $e->getFile();
    $line = $e->getLine();
    while (true) {
        $current = "$file:$line";
        if (is_array($seen) && in_array($current, $seen)) {
            $result[] = sprintf(' ... %d more', count($trace)+1);
            break;
        }
        $result[] = sprintf(' at %s%s%s(%s%s%s)',
            count($trace) && array_key_exists('class', $trace[0]) ? str_replace('\\', '.', $trace[0]['class']) : '',
            count($trace) && array_key_exists('class', $trace[0]) && array_key_exists('function', $trace[0]) ? '.' : '',
            count($trace) && array_key_exists('function', $trace[0]) ? str_replace('\\', '.', $trace[0]['function']) : '(main)',
            $line === null ? $file : basename($file),
            $line === null ? '' : ':',
            $line === null ? '' : $line);
        if (is_array($seen))
            $seen[] = "$file:$line";
        if (!count($trace))
            break;
        $file = array_key_exists('file', $trace[0]) ? $trace[0]['file'] : 'Unknown Source';
        $line = array_key_exists('file', $trace[0]) && array_key_exists('line', $trace[0]) && $trace[0]['line'] ? $trace[0]['line'] : null;
        array_shift($trace);
    }
    $result = join(PHP_EOL , $result);
    if ($prev)
        $result  .= PHP_EOL . jTraceEx($prev, $seen);
        
    return $result;
}
?>