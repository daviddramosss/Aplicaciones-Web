<?php

// Definición de una excepción personalizada llamada recetaAlreadyExistException
class recetaAlreadyExistException extends Exception
{
    // Constructor de la clase que extiende el constructor de la clase base Exception
    function __construct(string $message = "" , int $code = 0 , Throwable $previous = null )
    {
        // Llama al constructor de la clase base Exception para inicializar la excepción
        parent::__construct($message, $code, $previous);
    }
}

?>
