<?php

class recetaNotExistException extends Exception
{
    function __construct(string $message = "" , int $code = 1 , Throwable $previous = null )
    {
        parent::__construct($message, $code, $previous);
    }
}

?>