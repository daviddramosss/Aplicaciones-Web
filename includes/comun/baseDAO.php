<?php

abstract class baseDAO 
 {
    public function __construct()
    {
    }     

    protected function realEscapeString($field)
    {
        $conn = application::getInstance()->getConexionBd();

        return $conn->real_escape_string($field);
    }

    protected function ExecuteQuery($sql)
    {
        if($sql != "")
        {
            $conn = application::getInstance()->getConexionBd();

            $rs = $conn->query($sql);

            $tablaDatos = array();
            
            while ($fila = $rs->fetch_assoc())
            {  
                array_push($tablaDatos, $fila);
            }
                
            return $tablaDatos;
        } 
        else
        {
            return false;
        }
    }

    protected function ExecuteCommand($sql)
    {
        if($sql != "")
        {
            $conn = application::getInstance()->getConexionBd();

            if ( $conn->query($sql))
            {
                return $conn;
            }
        }

        return false;
    }
 }

 ?>