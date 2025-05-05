<?php

namespace es\ucm\fdi\aw\entidades\receta;
// Definición de una excepción personalizada para cuando una receta no existe
class recetaNotExistException extends Exception
{
    // Constructor de la excepción personalizada
    function __construct(string $message = "", int $code = 1, Throwable $previous = null)
    {
        // Llama al constructor de la clase base Exception con los mismos parámetros
        parent::__construct($message, $code, $previous);
    }
}

?>
